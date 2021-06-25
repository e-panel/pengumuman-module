<?php 

return [
	'title' => 'Pengumuman', 
	'desc' => 'Berikut ini adalah daftar seluruh data yang telah tersimpan di dalam database.', 
	'empty' => 'Sepertinya Anda belum memiliki :message.', 

	'created' => 'Data :title berhasil ditambah!', 
	'updated' => 'Data :title berhasil diubah!', 
	'deleted' => 'Beberapa data :title berhasil dihapus sekaligus!', 

	'create' => [
		'title' => 'Tambah :attribute', 
		'desc' => 'Silahkan lengkapi form berikut untuk menambahkan data baru.'
	],

	'edit' => [
		'title' => 'Ubah :attribute', 
		'desc' => 'Silahkan lakukan perubahan sesuai dengan kebutuhan.'
	], 

	'form' => [
		'title' => [
			'label' => 'Judul', 
			'placeholder' => 'Judul Pengumuman', 
		],
		'content' => [
			'label' => 'Isi Pengumuman', 
			'placeholder' => '', 
		],
		'attachment' => [
			'label' => 'Lampiran (Bila Ada)', 
			'placeholder' => '', 
			'view' => 'View File', 
			'notes' => 'Ekstensi yg didukung hanya <b>.pdf, .pptx, .docx, .png, &amp; .jpg</b>', 
		],
	],

	'table' => [
		'label' => 'LABEL', 
		'created' => 'CREATED', 
	],
];