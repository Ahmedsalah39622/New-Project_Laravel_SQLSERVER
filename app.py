import streamlit as st
import pandas as pd
from prophet import Prophet
import matplotlib.pyplot as plt
import numpy as np
from sklearn.metrics import mean_absolute_error, mean_squared_error
from datetime import datetime

st.set_page_config(page_title="توقع الحالات للأمراض", layout="centered")
st.title("📈 توقع عدد الحالات للأمراض المختلفة")
st.write("ارفع ملف بيانات بصيغة CSV يحتوي على عمود ds (التاريخ) وباقي الأعمدة لأسماء الأمراض")

with st.expander("📚 كيف نقيس دقة النموذج؟"):
    st.markdown("""
    **🎯 دقة النموذج (Accuracy):**
    - نسبة التوقعات الصحيحة بناءً على بيانات التدريب أو الشهور المستقبلية (إن توفرت)

    **📏 مقاييس الخطأ:**
    - **MAE:** متوسط حجم الأخطاء
    - **RMSE:** يعطي وزنًا أكبر للأخطاء الكبيرة
    - **MAPE:** نسبة الخطأ المئوية
    """)

uploaded_file = st.file_uploader("ارفع ملف CSV", type=["csv"])

if uploaded_file:
    df = pd.read_csv(uploaded_file)
    try:
        df['ds'] = pd.to_datetime(df['ds'])
        df = df.sort_values('ds')
        diseases = [col for col in df.columns if col != 'ds']
        last_date = df['ds'].max()
        st.sidebar.markdown(f"### 📅 آخر تاريخ في البيانات: {last_date.strftime('%Y-%m-%d')}")
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

                # تدريب النموذج
                m = Prophet(yearly_seasonality=True, weekly_seasonality=False, daily_seasonality=False)
                m.fit(df_selected)

                # توقع 3 شهور قادمة
                future = m.make_future_dataframe(periods=3, freq='MS')
                forecast = m.predict(future)
                future_forecast = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(3)

                # تقييم النموذج على البيانات التاريخية
                fitted = forecast[forecast['ds'].isin(df_selected['ds'])]
                y_true = df_selected['y'].values
                y_pred = fitted['yhat'].values

                mae = mean_absolute_error(y_true, y_pred)
                rmse = np.sqrt(mean_squared_error(y_true, y_pred))
                mape = np.mean(np.abs((y_true - y_pred) / (y_true + 1e-10))) * 100
                accuracy = 100 - mape

                st.subheader("📊 تقييم النموذج (استنادًا إلى البيانات التاريخية)")
                col1, col2, col3, col4 = st.columns(4)
                col1.metric("الدقة", f"{accuracy:.2f}%", delta=f"{mape:.2f}% نسبة الخطأ", delta_color="inverse")
                col2.metric("MAE", f"{mae:.2f}")
                col3.metric("RMSE", f"{rmse:.2f}")
                col4.metric("MAPE", f"{mape:.2f}%")
                st.progress(int(accuracy) / 100, text=f"مستوى الدقة: {accuracy:.2f}%")

                # تقييم الدقة للشهور المستقبلية إن توفرت البيانات
                future_dates = future_forecast['ds']
                future_actuals = df[df['ds'].isin(future_dates)][['ds', disease]].dropna()

                if not future_actuals.empty:
                    merged = pd.merge(future_forecast, future_actuals, on='ds')
                    y_true_future = merged[disease].values
                    y_pred_future = merged['yhat'].values

                    mae_future = mean_absolute_error(y_true_future, y_pred_future)
                    rmse_future = np.sqrt(mean_squared_error(y_true_future, y_pred_future))
                    mape_future = np.mean(np.abs((y_true_future - y_pred_future) / (y_true_future + 1e-10))) * 100
                    accuracy_future = 100 - mape_future

                    st.subheader("📉 تقييم دقة التنبؤ على الأشهر المستقبلية")
                    colf1, colf2, colf3, colf4 = st.columns(4)
                    colf1.metric("الدقة", f"{accuracy_future:.2f}%", delta=f"{mape_future:.2f}% نسبة الخطأ", delta_color="inverse")
                    colf2.metric("MAE", f"{mae_future:.2f}")
                    colf3.metric("RMSE", f"{rmse_future:.2f}")
                    colf4.metric("MAPE", f"{mape_future:.2f}%")
                    st.progress(int(accuracy_future) / 100, text=f"مستوى الدقة للشهور المستقبلية: {accuracy_future:.2f}%")
                else:
                    st.info("ℹ️ لا توجد بيانات حقيقية لمقارنة التوقعات المستقبلية.")

                # عرض التنبؤات
                st.subheader("📅 تنبؤات الأشهر الثلاثة القادمة")
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

                # رسم البيانات والتوقعات
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
