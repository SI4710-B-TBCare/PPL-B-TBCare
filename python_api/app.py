from flask import Flask, request, jsonify
import pickle
import pandas as pd
import os
import pandas as pd
import numpy as np
import joblib
import sklearn

app = Flask(__name__)

# Load model saat API pertama kali dijalankan
MODEL_PATH = os.path.join(os.path.dirname(__file__), 'tb_model.pkl')
model = pickle.load(open(MODEL_PATH, 'rb'))

FEATURE_COLS = ['CO', 'NS', 'BD', 'FV', 'CP', 'SP', 'IS', 'LP', 'CH', 'LC', 'IR', 'LA', 'LE', 'LNE', 'SBP', 'BMI']

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()

        # Validasi: semua fitur harus ada
        missing = [f for f in FEATURE_COLS if f not in data]
        if missing:
            return jsonify({'error': f'Fitur kurang: {missing}'}), 422

        # Validasi nilai: harus 0, 1, atau 2 (SP dan CO bisa 0-2, IS/LE bisa 0-3)
        for f in FEATURE_COLS:
            if not isinstance(data[f], int) or data[f] < 0 or data[f] > 3:
                return jsonify({'error': f'Nilai tidak valid untuk {f}: {data[f]}'}), 422

        # Buat DataFrame agar nama kolom sesuai dengan saat training
        df_input = pd.DataFrame([{f: data[f] for f in FEATURE_COLS}])

        # Prediksi probabilitas
        prob = model.predict_proba(df_input)[0][1]
        percentage = round(prob * 100, 2)

        # Tentukan kategori risiko
        if percentage < 30:
            risk_level = 'Rendah'
            risk_color = 'green'
        elif percentage < 60:
            risk_level = 'Sedang'
            risk_color = 'yellow'
        else:
            risk_level = 'Tinggi'
            risk_color = 'red'

        return jsonify({
            'probability'  : percentage,
            'risk_level'   : risk_level,
            'risk_color'   : risk_color,
            'status'       : 'success'
        })

    except Exception as e:
        return jsonify({'error': str(e), 'status': 'error'}), 500


@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok', 'model': 'tb_random_forest'})


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)
