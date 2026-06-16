"""
app_v2.py
=========
Flask API versi baru untuk model risiko TBC.

Perubahan dari app.py lama:
- Memuat 'tb_model_v2.pkl' (RandomForestRegressor) alih-alih
  'tb_model.pkl' (RandomForestClassifier).
- Menggunakan model.predict() yang langsung mengembalikan skor 0-100,
  alih-alih model.predict_proba()[0][1] * 100.
- Hasil di-clamp ke rentang [0, 100] untuk berjaga-jaga kalau regressor
  sedikit overshoot di luar rentang training.

Jangan lupa:
1. Jalankan train_tb_model_v2.py dulu di folder yang sama dengan file
   'tuberculosis_dataset.csv' untuk menghasilkan 'tb_model_v2.pkl'.
2. Copy 'tb_model_v2.pkl' ke folder yang sama dengan app_v2.py ini.
3. Matikan proses Flask lama (cek `lsof -i:5000` kalau perlu) sebelum
   menjalankan yang baru, supaya tidak ada instance lama yang masih
   memuat model lama di memori.
"""

from flask import Flask, request, jsonify
import pickle
import pandas as pd
import os

app = Flask(__name__)

MODEL_PATH = os.path.join(os.path.dirname(__file__), 'tb_model.pkl')
model = pickle.load(open(MODEL_PATH, 'rb'))

FEATURE_COLS = ['CO', 'NS', 'BD', 'FV', 'CP', 'SP', 'IS', 'LP', 'CH', 'LC',
                'IR', 'LA', 'LE', 'LNE', 'SBP', 'BMI']


@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()

        missing = [f for f in FEATURE_COLS if f not in data]
        if missing:
            return jsonify({'error': f'Fitur kurang: {missing}'}), 422

        for f in FEATURE_COLS:
            if not isinstance(data[f], int) or data[f] < 0 or data[f] > 3:
                return jsonify({'error': f'Nilai tidak valid untuk {f}: {data[f]}'}), 422

        df_input = pd.DataFrame([{f: data[f] for f in FEATURE_COLS}])

        # Regressor memprediksi skor risiko 0-100 secara langsung
        raw_score = float(model.predict(df_input)[0])
        percentage = round(max(0.0, min(100.0, raw_score)), 2)

        if percentage < 30:
            risk_level, risk_color = 'Rendah', 'green'
        elif percentage < 60:
            risk_level, risk_color = 'Sedang', 'yellow'
        else:
            risk_level, risk_color = 'Tinggi', 'red'

        return jsonify({
            'probability': percentage,
            'risk_level': risk_level,
            'risk_color': risk_color,
            'status': 'success'
        })

    except Exception as e:
        return jsonify({'error': str(e), 'status': 'error'}), 500


@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok', 'model': 'tb_random_forest_regressor'})


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)