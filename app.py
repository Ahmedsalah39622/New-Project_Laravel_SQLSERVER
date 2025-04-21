import streamlit as st
import pandas as pd
from prophet import Prophet
import matplotlib.pyplot as plt
import numpy as np
from sklearn.metrics import mean_absolute_error, mean_squared_error

st.set_page_config(page_title="توقع الحالات للأمراض", layout="centered")
st.title("📈 توقع عدد الحالات للأمراض المختلفة")
st.write("ارفع ملف بيانات بصيغة CSV يحتوي على عمود ds (التاريخ) وباقي الأعمدة لأسماء الأمراض")

with st.expander("📚 كيف نقيس دقة النموذج؟"):
    st.markdown("""
    **🎯 دقة النموذج (إذا توفرت بيانات فعلية مستقبلية):**
    - مقارنة بين التوقعات والبيانات الحقيقية للأشهر المستقبلية.

    **📏 مقاييس الخطأ (على البيانات التاريخية):**
    - **MAE:** متوسط حجم الأخطاء
    - **RMSE:** يعطي وزنًا أكبر للأخطاء الكبيرة
    - **MAPE:** نسبة الخطأ المئوية
    """)

uploaded_file = st.file_uploader("ارفع ملف CSV", type=["csv"])

months_to_predict = st.sidebar.slider("🔮 عدد الأشهر للتوقع", 1, 12, 3)

if uploaded_file:
    df = pd.read_csv(uploaded_file)
    try:
        df['ds'] = pd.to_datetime(df['ds'])
        df = df.sort_values('ds')
        diseases = [col for col in df.columns if col != 'ds']
        last_date = df['ds'].max()
        st.sidebar.markdown(f"### 📅 آخر تاريخ في البيانات: {last_date.strftime('%Y-%m')}")
    except Exception as e:
        st.error("تأكد من وجود عمود التاريخ (ds) وأعمدة الأمراض")
    else:
        for disease in diseases:
            st.markdown(f"---\n### 🔬 تحليل المرض: {disease}")
            try:
                df_selected = df[['ds', disease]].dropna().rename(columns={disease: 'y'})

                if len(df_selected) < 12:
                    st.warning("⚠ بيانات غير كافية للتدريب (تحتاج إلى 12 شهر على الأقل)!")
                    continue

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

                future = m.make_future_dataframe(periods=months_to_predict, freq='MS')
                forecast = m.predict(future)
                future_forecast = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(months_to_predict)

                # تقييم على التاريخ السابق
                fitted = forecast[forecast['ds'].isin(df_selected['ds'])]
                y_true = df_selected['y'].values
                y_pred = fitted['yhat'].values

                mae = mean_absolute_error(y_true, y_pred)
                rmse = np.sqrt(mean_squared_error(y_true, y_pred))
                mape = np.mean(np.abs((y_true - y_pred) / (y_true + 1e-10))) * 100

                # الدقة فقط إذا عندنا بيانات فعلية مستقبلية
                future_actual = df[df['ds'].isin(future_forecast['ds'])][['ds', disease]].dropna()
                if not future_actual.empty:
                    merged = pd.merge(future_forecast, future_actual, on='ds')
                    real_mape = np.mean(np.abs((merged[disease] - merged['yhat']) / (merged[disease] + 1e-10))) * 100
                    accuracy = 100 - real_mape
                else:
                    accuracy = 100 - mape

                st.subheader("📊 تقييم النموذج")
                col1, col2, col3, col4 = st.columns(4)
                col1.metric("الدقة", f"{accuracy:.2f}%", delta=f"{mape:.2f}% نسبة الخطأ", delta_color="inverse")
                col2.metric("MAE", f"{mae:.2f}")
                col3.metric("RMSE", f"{rmse:.2f}")
                col4.metric("MAPE", f"{mape:.2f}%")
                st.progress(min(int(accuracy), 100) / 100, text=f"مستوى الدقة: {accuracy:.2f}%")

                # تحذير إذا التوقعات مرتفعة جدًا
                last_year_avg = df_selected[df_selected['ds'] >= (last_date - pd.DateOffset(months=12))]['y'].mean()
                if future_forecast['yhat'].mean() > 1.25 * last_year_avg:
                    st.warning("📈 تنبيه: التوقعات أعلى بنسبة كبيرة من متوسط السنة الماضية!")

                st.subheader("📅 التنبؤات القادمة")
                display_df = future_forecast.copy()
                display_df['ds'] = display_df['ds'].dt.strftime('%Y-%m')
                display_df = display_df.rename(columns={
                    'ds': 'الشهر',
                    'yhat': 'القيمة المتوقعة',
                    'yhat_lower': 'الحد الأدنى',
                    'yhat_upper': 'الحد الأعلى'
                })
                st.dataframe(
                    display_df.style.format({
                        'القيمة المتوقعة': '{:.1f}',
                        'الحد الأدنى': '{:.1f}',
                        'الحد الأعلى': '{:.1f}'
                    }),
                    hide_index=True,
                    use_container_width=True
                )

                st.subheader("📊 التوقعات مقارنة بالبيانات التاريخية")
                fig, ax = plt.subplots(figsize=(12, 6))
                ax.plot(df_selected['ds'], df_selected['y'], 'bo-', label='البيانات الفعلية')
                ax.plot(future_forecast['ds'], future_forecast['yhat'], 'ro--', label='التنبؤات')
                ax.fill_between(
                    future_forecast['ds'],
                    future_forecast['yhat_lower'],
                    future_forecast['yhat_upper'],
                    color='pink', alpha=0.3, label='فاصل الثقة'
                )
                ax.set_xlabel('التاريخ')
                ax.set_ylabel('عدد الحالات')
                ax.set_title(f'توقع عدد الحالات لمرض {disease}')
                ax.legend()
                plt.xticks(rotation=45)
                plt.grid(True, linestyle='--', alpha=0.7)
                st.pyplot(fig)

            except Exception as e:
                st.error(f"❌ خطأ في تحليل {disease}: {str(e)}")


