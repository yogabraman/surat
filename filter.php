<?php

	function get_data(){
		$name = $this->input->post('name');
    $id_mitra = $this->session->userdata('id_mitra');
    $id_user = $this->session->userdata('id_user');
		$kecamatan = $this->db->query("SELECT * FROM tbl_surat_masuk WHERE (isi LIKE '%$cari%') OR (asal_surat LIKE '%$cari%') ORDER by id_surat DESC LIMIT $curr, $limit");
		foreach($kecamatan->result() as $value) {
			$hasil_rupiah = number_format($value->price);
			$data[] = array(
				'price' => $hasil_rupiah
			);
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($data);
	}

?>