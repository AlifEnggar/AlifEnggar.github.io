// let nama = "Alif Enggar Arzaki";
// let tempattanggalLahir = "Banjarnegra, 24 November 2009";
// let alamat = "Beji Bendawuluh RT 1 Rw 3, Banjarmangun, Banjarnegara";
// let email = "Alifenggararzaki@gmail.com";
// let hobi = "Bermain Game, Membaca Novel/Manga";

// console.log("Nama : " + nama);
// console.log("Tempat, Tanggal Lahir : " + tempattanggalLahir);
// console.log("Alamat : " + alamat);
// console.log("Email : " + email);
// console.log("Hobi : " + hobi);

const readline = require("readline");
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

rl.question("Masukkan jumlah barang yang ingin dibeli : ", function (jumlah) {
  let namabarang = "tiket bus";
  let harga = 50000;
  let total = harga * parseInt(jumlah);
  let diskon = 0.05 * total;
  let totalbayar = total - diskon;
  console.log("Nama Barang : " + namabarang);
  console.log("Harga : " + harga);
  console.log("Jumlah : " + jumlah);
  console.log("Total : " + total);
  console.log("Diskon : " + diskon);
  console.log("Total Bayar : " + totalbayar);

  rl.close();
});
