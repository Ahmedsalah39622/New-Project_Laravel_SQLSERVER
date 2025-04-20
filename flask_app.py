from flask import Flask, request, jsonify
import pandas as pd
from prophet import Prophet
from sklearn.metrics import mean_absolute_error, mean_squared_error
import numpy as np

app = Flask(__name__)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Get the uploaded CSV file and parameters
        file = request.files['file']
        months_to_predict = int(request.form.get('months_to_predict', 3))

        # Read the CSV file
        df = pd.read_csv(file)
        df['ds'] = pd.to_datetime(df['ds'])
        df = df.sort_values('ds')

        # Exclude unwanted columns
        excluded_columns = ['id', 'created_at', 'updated_at']
        diseases = [col for col in df.columns if col not in excluded_columns + ['ds']]

        if not diseases:
            return jsonify({"success": False, "error": "No valid disease columns found in the file."}), 400

        predictions = {}

        # Iterate over each disease and make predictions
        for disease in diseases:
            df_selected = df[['ds', disease]].dropna().rename(columns={disease: 'y'})

            if len(df_selected) < 12:
                predictions[disease] = {"error": "Not enough data for training (minimum 12 months required)."}
                continue

            # Train the Prophet model
            m = Prophet(
                yearly_seasonality=True,
                weekly_seasonality=False,
                daily_seasonality=False,
                changepoint_prior_scale=0.1,
                seasonality_prior_scale=10,
                holidays_prior_scale=10,
                interval_width=0.95
            )
            m.fit(df_selected)

            # Make future predictions
            future = m.make_future_dataframe(periods=months_to_predict, freq='MS')
            forecast = m.predict(future)
            future_forecast = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(months_to_predict)

            # Evaluate the model on historical data
            fitted = forecast[forecast['ds'].isin(df_selected['ds'])]
            y_true = df_selected['y'].values
            y_pred = fitted['yhat'].values

            mae = mean_absolute_error(y_true, y_pred)
            rmse = np.sqrt(mean_squared_error(y_true, y_pred))
            mape = np.mean(np.abs((y_true - y_pred) / (y_true + 1e-10))) * 100

            # Add historical data to the response
            historical_data = fitted[['ds', 'yhat']].rename(columns={'yhat': 'y'}).to_dict(orient='records')

            # Convert predictions to JSON
            predictions[disease] = {
                "historical_data": historical_data,
                "future_forecast": future_forecast.to_dict(orient='records'),
                "metrics": {
                    "mae": mae,
                    "rmse": rmse,
                    "mape": mape
                }
            }

        return jsonify({"success": True, "predictions": predictions})

    except Exception as e:
        return jsonify({"success": False, "error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
