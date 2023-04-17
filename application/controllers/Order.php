<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('TransaksiModel');
		$this->load->model('SantriModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'order', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/order',
			'plugin' => 'plugins/order',
			'css' => 'css/order',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$list = $this->TransaksiModel->getOrder();
		// var_dump($list);
		// echo $this->db->last_query($list);
		// die;
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $ls) {
			if ($ls->status_paid == 203) {
				$action = '<div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';
				$status = '<span class="badge iq-bg-danger">Belum dibayar</span>';
			} else if ($ls->status_paid == 201) {
				$action  = '';
				$status = '<span class="badge iq-bg-warning">Diproses</span>';
			} else if ($ls->status_paid == 200) {
				$action  = '';
				$status = '<span class="badge iq-bg-primary">Selesai</span>';
			} else {
				$action  = '';
				$status = '';
			}

			$row = array();
			$row[] = $ls->order_id;
			$row[] = $ls->nis;
			$row[] = $ls->name;
			$row[] = $ls->wali_santri;
			$row[] = $ls->gross_amount;
			$row[] = $status;
			$row[] = $this->TransaksiModel->count_item($ls->id)->row('total_item');
			$row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->TransaksiModel->count_all(),
			"recordsFiltered" => $this->TransaksiModel->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function delete()
	{
		$id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
		$act = $this->TransaksiModel->delete($id);
		if ($act) {
			log_activity('delete', 'delete order', 'delete data order pada halaman order');
			$response = array(
				'type' => 'success',
				'title' => 'Berhasil !!!',
				'message' => 'Data order berhasil dihapus.'
			);
		} else {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Data order gagal dihapus !'
			);
		}

		// echo $this->db->last_query($act);
		// die;
		echo json_encode($response);
	}

	public function pay()
	{
		$tag_id = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));
		$santri = $this->SantriModel->GetSantriByTag(str_replace("'", "", htmlspecialchars($tag_id, ENT_QUOTES)));
		if ($santri->num_rows() > 0) {
			$data = $santri->row();
			$act = $this->TransaksiModel->GetTransactionBySantri($data->id_santri)->row_array();

			// echo '<pre>' . print_r($act, 1) . '</pre>';
			// die;

			if ($act) {

				if ($act['saldo'] >= $act['gross_amount']) {
					$response = array(
						'type' => 'success',
						'title' => 'Berhasil !!!',
						'message' => 'Sisa saldo ' . number_format($act['saldo'] - $act['gross_amount'])
					);

					$this->TransaksiModel->update($act['bill_id'], ['status_paid' => 200]);
					$this->SantriModel->update($data->id, ['saldo' => intval($act['saldo']) - intval($act['gross_amount'])]);
				} else {
					$response = array(
						'type' => 'error',
						'title' => 'Gagal !!!',
						'message' => 'Saldo kurang ' . number_format($act['saldo'])
					);
				}
				echo json_encode($response);
			} else {
				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Tidak ada tagihan pembayaran'
				);

				echo json_encode($response, true);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => 'Tag tidak ditemukan'
			);

			echo json_encode($response, true);
		}
	}
}
