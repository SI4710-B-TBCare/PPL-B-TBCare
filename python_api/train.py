"""
train_tb_model_v2.py
=====================
Versi baru skrip training model risiko TBC.

PERUBAHAN UTAMA dari train.py lama:
1. Skor "ground truth" (Target_Score) sekarang dihitung per-gejala secara
   independen (dinormalisasi 0-1 per kolom, lalu dikali bobot klinis),
   bukan dijumlahkan dulu per grup lalu dikali bobot grup. Ini mencegah
   satu gejala yang nol "menyeret turun" gejala lain yang sebenarnya parah.
2. Total bobot = 100, sehingga Target_Score langsung berada di skala 0-100
   dan bisa dibaca langsung sebagai persentase risiko.
3. Model diganti dari RandomForestClassifier (+ predict_proba) menjadi
   RandomForestRegressor yang memprediksi skor 0-100 secara langsung.
   RandomForestClassifier yang dilatih dari label biner (hasil threshold
   median) cenderung menghasilkan probabilitas ekstrem (mendekati 0%/100%)
   begitu pohon-pohonnya yakin -- regressor menghasilkan output yang lebih
   halus, proporsional dengan jumlah & beratnya gejala.

CATATAN PENTING:
- Bobot di bawah ini adalah heuristik berbasis pengetahuan umum tentang
  gejala kardinal TBC (batuk, demam, keringat malam, penurunan berat
  badan) dan faktor risiko (penurunan imunitas), BUKAN hasil validasi
  klinis/statistik formal. Sebaiknya didiskusikan dengan dosen
  pembimbing/pakar medis sebelum dipakai sebagai dasar keputusan nyata.
- Kolom 'SBP' (tekanan darah sistolik) diberi bobot 0 karena secara
  klinis tidak relevan sebagai indikator TBC. Pertimbangkan untuk
  menghapusnya dari fitur di masa depan -- untuk saat ini tetap
  dipertahankan agar struktur fitur (16 kolom) tidak berubah dan
  kompatibel dengan form/controller yang sudah ada.
- Kolom 'CO' di dataset punya rentang 0-3, tapi form & validasi
  controller saat ini membatasi 0-2. Sebaiknya disamakan (lihat
  pembahasan sebelumnya) supaya pengguna bisa mengirim nilai maksimum
  yang benar-benar dipelajari model.
"""

import pandas as pd
import pickle
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_absolute_error, r2_score

print("1. Membaca dataset...")
try:
    df = pd.read_csv('tuberculosis_dataset.csv')
    if 'CO' not in df.columns:
        df = pd.read_csv('tuberculosis_dataset.csv', skiprows=1)
except Exception as e:
    print("Gagal membaca file:", e)
    raise

# ============================================================
# BOBOT KLINIS -- total harus = 100
# ============================================================
WEIGHTS = {
    'CO':  16,  # Batuk - gejala kardinal/vital
    'FV':  10,  # Demam - gejala kardinal/vital
    'NS':  10,  # Keringat malam - gejala kardinal/vital
    'BMI': 10,  # Underweight sebagai proxy penurunan berat badan
    'SP':  12,  # Jenis dahak - hemoptisis (darah) adalah tanda penting
    'IS':  10,  # Penurunan imunitas - faktor risiko kuat utk TBC aktif
    'LNE':  6,  # Pembengkakan kelenjar limfa - tanda TBC ekstraparu
    'BD':   6,  # Kesulitan bernapas
    'CP':   5,  # Nyeri dada
    'LA':   4,  # Kehilangan nafsu makan
    'LE':   4,  # Kehilangan energi
    'CH':   3,  # Menggigil
    'LP':   2,  # Kehilangan minat
    'LC':   1,  # Sulit berkonsentrasi
    'IR':   1,  # Mudah tersinggung
    'SBP':  0,  # Tidak relevan klinis utk TBC
}
assert sum(WEIGHTS.values()) == 100, "Total bobot harus 100"

# Kolom dengan skala 0-3 di dataset; sisanya default 0-2
MAX_VAL = {'CO': 3, 'IS': 3, 'LE': 3}
def max_of(col):
    return MAX_VAL.get(col, 2)

def sp_risk(x):
    # SP bukan skala severity linear, tapi kategori jenis dahak:
    # 0=Berdarah (paling berisiko/hemoptisis)
    # 2=Kehijauan (sedang, indikasi infeksi), 
    # 1=Bening (paling rendah risikonya)
    return {0: 1.0, 2: 0.5, 1: 0.0}[x]

def bmi_risk(x):
    # PERBAIKAN: BMI bukan skala severity linear seperti gejala lain.
    # 0=Underweight/Kurus adalah risiko TBC (penurunan berat badan),
    # 1=Normal dan 2=Overweight/Obesitas BUKAN faktor risiko TBC.
    return {0: 1.0, 1: 0.0, 2: 0.0}[x]

def compute_score(row):
    score = 0.0
    for col, w in WEIGHTS.items():
        if w == 0:
            continue
        if col == 'SP':
            score += sp_risk(row['SP']) * w
        elif col == 'BMI':
            score += bmi_risk(row['BMI']) * w
        else:
            score += (row[col] / max_of(col)) * w
    return score

print("2. Menghitung skor klinis (Target_Score) 0-100...")
df['Target_Score'] = df.apply(compute_score, axis=1)
print(df['Target_Score'].describe())

print("3. Menyiapkan Fitur (X) dan Target (y)...")
FEATURE_COLS = ['CO', 'NS', 'BD', 'FV', 'CP', 'SP', 'IS', 'LP', 'CH', 'LC',
                'IR', 'LA', 'LE', 'LNE', 'SBP', 'BMI']
X = df[FEATURE_COLS]
y = df['Target_Score']

print("4. Membagi data latih dan data uji (80% Training, 20% Testing)...")
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

print("5. Melatih RandomForestRegressor...")
model = RandomForestRegressor(n_estimators=300, min_samples_leaf=4, random_state=42)
model.fit(X_train, y_train)

print("6. Mengevaluasi model...")
y_pred = model.predict(X_test)
mae = mean_absolute_error(y_test, y_pred)
r2 = r2_score(y_test, y_pred)

print("\n=== HASIL EVALUASI MODEL ===")
print(f"MAE (rata-rata selisih persentase) : {mae:.2f}") # Selisih antara nilai aktual dan prediksi
print(f"R2 Score                            : {r2:.3f}") # Seberapa baik model
print("============================\n")

print("7. Menyimpan model ke dalam file .pkl...")
with open('tb_model.pkl', 'wb') as file:
    pickle.dump(model, file)

print("Selesai! File 'tb_model.pkl' berhasil dibuat.")