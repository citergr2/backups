// ==============================================================================
// BOT XITERCSX - CARI PRODUK SESUAI NAMA YANG DITULIS USER
// ==============================================================================
process.env.TZ = 'Asia/Jakarta';
const { default: makeWASocket, useMultiFileAuthState } = require('@whiskeysockets/baileys');
const mysql = require('mysql2/promise');
const qrcode = require('qrcode-terminal');
const { createCanvas } = require('canvas');
const fs = require('fs');
const path = require('path');

// ✅ KONFIGURASI
const config = {
  nomorAdmin: '6287868300595',
  namaToko: 'XITERCSX STORE x Storepaktorz',
  dbHost: 'localhost',
  dbUser: 'xitercsx_admin',
  dbPass: 'citergrwwq12e',
  dbName: 'xitercsx_db'
};

const db = mysql.createPool({
  host: config.dbHost,
  user: config.dbUser,
  password: config.dbPass,
  database: config.dbName,
  waitForConnections: true,
  connectionLimit: 10
});

async function cekDatabase() {
  try {
    await db.query('SELECT 1');
    console.log('✅ DATABASE TERHUBUNG!');
    await db.query(`
      CREATE TABLE IF NOT EXISTS testimoni (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        isi TEXT NOT NULL,
        waktu DATETIME DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);
    console.log('✅ Tabel Testimoni Siap!');
    return true;
  } catch (e) {
    console.error('❌ DB ERROR:', e.message);
    return false;
  }
}

function ambilNomor(jid) {
  return jid.replace(/[^0-9]/g, '');
}

async function kirim(sock, ke, teks) {
  try { await sock.sendMessage(ke, { text: teks }); }
  catch (e) { console.log('❌ GAGAL KIRIM:', e.message); }
}

async function buatBuktiGambar(data) {
  const lebar = 600, tinggi = 420;
  const kanvas = createCanvas(lebar, tinggi);
  const ctx = kanvas.getContext('2d');
  ctx.fillStyle = '#1a0000';
  ctx.fillRect(0, 0, lebar, tinggi);
  ctx.strokeStyle = '#b8860b';
  ctx.lineWidth = 4;
  ctx.strokeRect(10, 10, lebar - 20, tinggi - 20);
  ctx.fillStyle = '#ffffff';
  ctx.font = 'bold 26px Arial';
  ctx.textAlign = 'center';
  ctx.fillText('BUKTI TRANSAKSI', lebar / 2, 55);
  ctx.font = 'bold 18px Arial';
  ctx.fillText(config.namaToko, lebar / 2, 85);
  ctx.font = '17px Arial';
  ctx.textAlign = 'left';
  let y = 140;
  const baris = (label, nilai) => {
    ctx.fillStyle = '#aaaaaa';
    ctx.fillText(label, 50, y);
    ctx.fillStyle = '#ffffff';
    ctx.fillText(nilai, 260, y);
    y += 38;
  };
  baris('Produk', data.produk);
  baris('Nomor Pembeli', data.pembeli);
  baris('Total Bayar', 'Rp ' + data.nominal.toLocaleString('id-ID'));
  baris('Kode Unik', data.kode);
  baris('Waktu', data.waktu);
  const folder = path.join(__dirname, 'bukti');
  if (!fs.existsSync(folder)) fs.mkdirSync(folder, { recursive: true });
  const lokasiFile = path.join(folder, `bukti_${Date.now()}.png`);
  fs.writeFileSync(lokasiFile, kanvas.toBuffer('image/png'));
  return lokasiFile;
}

async function simpanTestimoniDB(nomor, namaBarang, waktu) {
  try {
    await db.query('INSERT INTO testimoni (nama, isi) VALUES (?, ?)', [
      nomor,
      `${namaBarang} - dibeli pada ${waktu}`
    ]);
    console.log('✅ Testimoni TERSIMPAN!');
  } catch (err) {
    console.log('❌ Gagal simpan testi:', err.message);
  }
}

async function mulaiBot() {
  await cekDatabase();
  const { state, saveCreds } = await useMultiFileAuthState('auth');
  const sock = makeWASocket({ auth: state, syncFullHistory: false });
  sock.ev.on('creds.update', saveCreds);
  sock.ev.on('connection.update', u => {
    if (u.qr) qrcode.generate(u.qr, { small: true });
    if (u.connection === 'open') console.log('✅ BOT ONLINE!');
  });

  sock.ev.on('messages.upsert', async m => {
    const pesan = m.messages[0];
    if (!pesan.key.fromMe && pesan.message) {
      const pengirim = pesan.key.remoteJid;
      const teks = pesan.message.conversation || pesan.message.extendedTextMessage?.text || '';
      const teksBersih = teks.toLowerCase().trim();
      const nomor = ambilNomor(pengirim);

      try {
        // 1. DANA MASUK
        if (teksBersih.includes('dana') && teksBersih.includes('masuk')) {
          const ambilNominal = teks.match(/Rp\s*([\d.]+)/i) || teks.match(/(\d{1,3}\.\d{3})/);
          if (!ambilNominal) return;
          const nominal = parseInt(ambilNominal[1].replace(/\./g, ''));
          const kode = nominal % 1000;
          await db.query('INSERT INTO pesanan (nama,produk,harga,kode_unik,status) VALUES (?,?,?,?,?)',
            ['Pembayaran DANA', '-', nominal, kode, 'terkonfirmasi']);
          await kirim(sock, pengirim, `✅ Pembayaran tercatat! Rp ${nominal.toLocaleString('id-ID')} | Kode: ${kode}`);
          return;
        }

        // 2. PROSES KONFIRMASI BAYAR + CARI PRODUK SESUAI NAMA
        if (teksBersih.includes('sudah melakukan pembayaran') || teksBersih.includes('sudah bayar')) {
          // ✅ BACA DATA DARI PESAN USER
          const ambilNamaProduk = teks.match(/📦\s*Produk\s*:\s*(.+?)(?=\n|💰|$)/i)?.[1].trim();
          const ambilKode = teks.match(/🔑\s*Kode Unik\s*:\s*(\d{3})/i)?.[1] || teks.match(/\b(\d{3})\b/)?.[1];

          if (!ambilKode) return await kirim(sock, pengirim, '⚠️ Masukkan Kode Unik 3 angka!');
          if (!ambilNamaProduk) return await kirim(sock, pengirim, '⚠️ Tuliskan Nama Produk yang dibeli!');

          const kodeCari = ambilKode;
          const namaProdukUser = ambilNamaProduk;

          // ✅ CEK KODE PEMBAYARAN DULU
          const [dataPesanan] = await db.query('SELECT * FROM pesanan WHERE kode_unik=? AND status=? ORDER BY id DESC LIMIT 1', [kodeCari, 'terkonfirmasi']);

          if (dataPesanan.length === 0) {
            return await kirim(sock, pengirim, '❌ Belum tercatat! Tunggu sebentar ya.');
          }

          const d = dataPesanan[0];
          const hargaProduk = d.harga - d.kode_unik;

          // ✅ CARI PRODUK DI DB: SESUAIKAN HARGA DAN NAMA YANG DITULIS USER
          const [produk] = await db.query(
            'SELECT nama, link_mf FROM produk WHERE harga = ? AND LOWER(nama) LIKE ? LIMIT 1',
            [hargaProduk, `%${namaProdukUser.toLowerCase()}%`]
          );

          if (produk.length === 0) {
            await kirim(sock, pengirim, `❌ Produk tidak ditemukan! Cek kembali nama produk: ${namaProdukUser}`);
            return;
          }

          const namaBarang = produk[0].nama;
          const link = produk[0].link_mf;
          const waktuTransaksi = new Date().toLocaleString('id-ID', {
            day: '2-digit', month: 'long', year: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: false
          });

          // ✅ KIRIM HASIL KE PEMBELI
          await kirim(sock, pengirim, `✅ TERKONFIRMASI! 🎉
📦 Produk: ${namaBarang}
💰 Total: Rp ${d.harga.toLocaleString('id-ID')}
🔗 LINK: ${link}
Terima kasih!`);

          await db.query('UPDATE pesanan SET status=?, produk=? WHERE id=?', ['selesai', namaBarang, d.id]);
          await simpanTestimoniDB(nomor, namaBarang, waktuTransaksi);

          const fileBukti = await buatBuktiGambar({ produk: namaBarang, pembeli: nomor, nominal: d.harga, kode: ambilKode, waktu: waktuTransaksi });

          await kirim(sock, config.nomorAdmin+'@s.whatsapp.net', `📤 LAPORAN PENJUALAN
━━━━━━━━━━━━━━━━━━
📦 Produk: ${namaBarang}
👤 Pembeli: ${nomor}
💰 Nominal: Rp ${d.harga.toLocaleString('id-ID')}
🔑 Kode: ${ambilKode}
🕒 Waktu: ${waktuTransaksi}
🖼️ BUKTI LENGKAP`);

          await sock.sendMessage(config.nomorAdmin+'@s.whatsapp.net', { image: { url: fileBukti }, caption: 'BUKTI LENGKAP' });
          fs.unlinkSync(fileBukti);

          console.log(`✅ PRODUK DITEMUKAN: ${namaBarang}`);
          return;
        }

        // ✅ CONTOH FORMAT PESAN
        if (teksBersih.includes('halo')) {
          await kirim(sock, pengirim, `👋 Halo! Gunakan format ini:

Halo Admin! 🙏

Saya sudah melakukan pembayaran:
📦 Produk: 
💰 Nominal Transfer: Rp
🔑 Kode Unik: 

Mohon dicek, terima kasih!`);
        }

      } catch (e) {
        console.error('❌ ERROR:', e.message);
      }
    }
  });
}

mulaiBot().catch(e => console.error('❌ GAGAL TOTAL:', e));
