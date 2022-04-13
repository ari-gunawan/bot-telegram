<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

require_once '../vendor/autoload.php';
require_once '../database/configDB.php';

$configs = [
    "telegram" => [
        "token" => file_get_contents("private/token.txt")
    ]
];

DriverManager::loadDriver(TelegramDriver::class);

$botman = BotManFactory::create($configs);

// Command no @ to bot
$botman->hears("/start", function (BotMan $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $id_user = $user->getId();

    $bot->reply("Halo $firstname $lastname (ID:$id_user),terima kasih telah menghubungi Hotline Kanwil 2 BRI DKI Jakarta, senang bisa berinteraksi dengan anda");
    include "command/requestChat.php";
    $bot->reply("Bagaimana kami bisa membantu Anda? Harap menggunakan menu /panduan\ untuk melanjutkan percakapan");
});

$botman->hears("/panduan", function (Botman $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $bot->replay("Selamat datang $firstname $lastname,\n 
    berikut perintah yang dapat dilakuan di Bot Hotline ini \n 
    ---------------------------------\n
    /register\ : untuk melakukan register bot dengan format sbb \n\n 
    /register\ pn#nama#kode_uker#nomor_hp\n\n 
    contoh: /register\ \n 
    00012345#ferdana#0845#083838383 \n
    --------------------------------- \n\n
    /komplain\ : untuk melakukan komplain kepada kanwil dengan format sbb\n\n
    /komplain\ : judul_komplain#isi_komplain \n\n
    contoh : /komplain\ aplikasi brinet lambat#kenapa aplikasi brinet di uker lambar?
    sudah sampai hampir 3 jam seperti nin. mohon solusinya \n\n
    setelah membuat tiket komplain dan tiket belum close anda dapat melakukan percakapan seperi biasa di bot dapat mengirimkan gamabar atau media pendukung) \n\n
    contoh \n\n
    user    : gimana nih prosesnya?\n
    kanwil  : mohon ditunggu bapak/ibu kampi FU ke kantor pusat.\n\n
    ---------------------------------\n
    /info\ : untuk melakukan tiket permohonan info kepada kanwil dengan format sbb\n\n
    /info\ judul permohonan info#isi permohonan info#\n\n
    contoh: /info\ mohon info brach dan tiket belum close anda dapat melakukan percakapan seperti biasa di bot (dapat mengirimkan gambar atau media pendukung)\n\n
    contoh : \n
    user    : gimana nih prosesnya?\n
    kanwil  : mohon ditunggu detail tiket dengan format sbb\n\n
    ---------------------------------\n
    /info_tiket\ : untuk melihat detail tiket dengan format sbb \n\n
    /info_tiket\ id tiket\n\n
    contoh : /info_tiket\ 123123123123123123\n
    ---------------------------------\n
    /close_tiket\ : untuk close tiket aktif dari pengguna\n\n
    contoh : /close_tiket\ ");
});

$botman->hears("/register {pn}#{nama}#{nomor_uker}#{nomor_hp}", function (Botman $bot, $pn, $nama, $nomor_uker, $nomor_hp) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    $pn = $pn;
    $nama = $nama;
    $nomor_uker = $nomor_uker;
    $nomor_hp = $nomor_hp;

    include "command/requestChat.php";
    include "command/insertDataCatatan.php";

    $message = insertDataCatatan($id_user, $pn, $nama, $nomor_uker, $nomor_hp);
    $bot->reply($message);
});

$botman->hears("/komplain {jd_komplain}#{isi_komplain}", function (Botman $bot, $pn, $jd_komplain, $isi_komplain) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $pn = $user->getId();

    $jd_komplain = $jd_komplain;
    $isi_komplain = $isi_komplain;

    include "command/requestChat.php";
    include "command/insertKomplain.php";

    $message = insertDataCatatan($pn, $jd_komplain, $isi_komplain);
    $bot->reply($message);
});

$botman->hears("/info {jd_info}#{isi_info}", function (Botman $bot, $pn, $jd_info, $isi_info) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    $jd_info = $jd_info;
    $isi_info = $isi_info;

    include "command/requestChat.php";
    include "command/insertInfo.php";

    $message = insertDataCatatan($pn, $jd_info, $isi_info);
    $bot->reply($message);
});

$botman->hears("/info_tiket {tiket}", function (Botman $bot, $tiket) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $tiket = $tiket;

    include "command/infoTiket.php";

    $message = infoTiket($id_user, $tiket);
    $bot->reply($message);
});

// ------------------------------------------------------------pembatas---------------------------------------------------------- 
// Command with @ to bot
$botman->hears("/start@Aisyah_Bukan_Bot", function (BotMan $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    $id = $user->getId();

    $bot->reply("Assalamualaikum $firstname (ID:$id_user),\nNama Saya Aisyah Salma. Selamat Datang Di Layanan Sekretaris Pribadi Anda.\n\nKetikkan Perintah /help Untuk Mengetahui Menu Perintah Yang Bisa Saya Kerjakan");
    include "command/requestChat.php";
});

$botman->hears("/help@Aisyah_Bukan_Bot", function (Botman $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $bot->reply("/lihat_catatan_tugas_kuliah@Aisyah_Bukan_Bot \n*Untuk Melihat Catatan M.K");
    $bot->reply("/tambah_catatan_tugas_kuliah@Aisyah_Bukan_Bot \n*Untuk Membuat Catatan M.K");
    $bot->reply("/edit_catatan_tugas_kuliah@Aisyah_Bukan_Bot \n*Untuk Mengedit Catatan M.K");
    $bot->reply("/hapus_catatan_tugas_kuliah@Aisyah_Bukan_Bot \n*Untuk Menghapus Catatan M.K");
});

$botman->hears("/lihat_catatan_tugas_kuliah@Aisyah_Bukan_Bot", function (Botman $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";
    include "command/viewDataUser.php";

    $message = viewCatatanUser($id_user);
    $bot->reply($message);
});

$botman->hears("/tambah_catatan_tugas_kuliah@Aisyah_Bukan_Bot", function (BotMan $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $bot->reply("Format Tambah Catatan Tugas Kuliah :\n\n/tambah_catatan [Nama Mata Kuliah]_[Catatan Mata Kuliah]_[Deadline M.K]\n\n*Tanpa Tanda Kurung []");
});

$botman->hears("/tambah_catatan@Aisyah_Bukan_Bot {nama_mk}_{catatan_mk}_{deadline_mk}", function (Botman $bot, $nama_mk, $catatan_mk, $deadline_mk) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $nama_mk = $nama_mk;
    $catatan_mk = $catatan_mk;
    $deadline_mk = $deadline_mk;

    include "command/insertDataCatatan.php";

    $message = insertDataCatatan($id_user, $nama_mk, $catatan_mk, $deadline_mk);
    $bot->reply($message);
});

$botman->hears("/edit_catatan_tugas_kuliah@Aisyah_Bukan_Bot", function (Botman $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $bot->reply("Format Edit Catatan Tugas Kuliah :\n\n/edit_catatan [Pilih ID Kode MK]_[Nama Mata Kuliah Baru]_[Catatan Mata Kuliah Baru]_[Deadline M.K Baru]\n\n*Tanpa Tanda Kurung []");
});

$botman->hears("/edit_catatan@Aisyah_Bukan_Bot {kode_mk}_{nama_mk}_{catatan_mk}_{deadline_mk}", function (Botman $bot, $kode_mk, $nama_mk, $catatan_mk, $deadline_mk) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $kode_mk = $kode_mk;
    $nama_mk = $nama_mk;
    $catatan_mk = $catatan_mk;
    $deadline_mk = $deadline_mk;

    include "command/updateDataCatatan.php";

    $message = updateDataCatatan($id_user, $kode_mk, $nama_mk, $catatan_mk, $deadline_mk);
    $bot->reply($message);
});

$botman->hears("/hapus_catatan_tugas_kuliah@Aisyah_Bukan_Bot", function (Botman $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $bot->reply("Format Hapus Catatan Tugas Kuliah :\n\n/hapus_catatan [Pilih ID Kode MK Yang Ingin Dihapus]\n\n*Tanpa Tanda Kurung []");
});

$botman->hears("/hapus_catatan@Aisyah_Bukan_Bot {kode_mk}", function (Botman $bot, $kode_mk) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $kode_mk = $kode_mk;

    include "command/delDataCatatan.php";

    $message = delDataCatatan($id_user, $kode_mk);
    $bot->reply($message);
});

$botman->hears("/cari_catatan@Aisyah_Bukan_Bot {kode_mk}", function (Botman $bot, $kode_mk) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();

    include "command/requestChat.php";

    $kode_mk = $kode_mk;

    include "command/cariDataCatatan.php";

    $message = cariDataCatatan($id_user, $kode_mk);
    $bot->reply($message);
});

// command not found
$botman->fallback(function (BotMan $bot) {
    $message = $bot->getMessage()->getText();
    $bot->reply("Maaf, Perintah Ini '$message' Tidak Ada 😐");
});


$botman->listen();
