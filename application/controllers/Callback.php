<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Xendit\Xendit;

class Callback extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$config = $this->db->get('config')->result_array();
		foreach ($config as $cf) {
			define("_{$cf['name']}", $cf['value']);
		}

		Xendit::setApiKey(_XENDIT_KEY);
	}

	public function EWallet()
	{
		$reqHeaders = getallheaders();
		$xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";

		if ($xIncomingCallbackTokenHeader === _XENDIT_CALLBACK_TOKEN) {

			$json_result = file_get_contents('php://input');
			$result = json_decode($json_result, true);

			// var_dump($result);
			// die;

			$orderid = $result['data']['reference_id'];

			if ($result['data']['status'] == 'SUCCEEDED') {
				$data['status_paid'] = 200;
				$data['paid_at'] = date('YmdHis');
				$this->db->update('bills', $data, ['order_id' => $orderid]);
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Pembayaran ' . $orderid . ' berhasil.'
				);
			} else if ($result['data']['status'] == 'FAILED' || $result['data']['status'] == 'VOIDED') {
				$get = $this->db->get_where('bills', ['order_id' => $orderid]);
				if ($get->num_rows() > 0) {
					$this->db->delete('bills', ['order_id' => $orderid]);
				} else {
					return false;
				}

				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Pembayaran ' . $orderid . ' gagal atau kadaluwarsa.'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => http_response_code(403)
			);
		}

		echo json_encode($response);
	}

	public function VirtualAccount()
	{
		$reqHeaders = getallheaders();
		$xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";

		if ($xIncomingCallbackTokenHeader === _XENDIT_CALLBACK_TOKEN) {
			$json_result = file_get_contents('php://input');
			$result = json_decode($json_result, true);

			$expire = new DateTime('now');
			$orderid = $result['external_id'];

			if (!empty($result['payment_id'])) {
				$data['status_paid'] = 200;
				$data['paid_at'] = date('YmdHis');
				$this->db->update('bills', $data, ['order_id' => $orderid]);
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Pembayaran ' . $orderid . ' berhasil.'
				);
			} else if ($result['status'] == 'INACTIVE' || strtotime($result['expiration_date']) < strtotime($expire->format(DateTimeInterface::ISO8601))) {
				$get = $this->db->get_where('bills', ['order_id' => $orderid]);
				if ($get->num_rows() > 0) {
					$this->db->delete('bills', ['order_id' => $orderid]);
				} else {
					return false;
				}

				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Pembayaran ' . $orderid . ' gagal atau kadaluwarsa.'
				);
			} else {
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Billing berhasil dibuat.'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => http_response_code(403)
			);
		}

		echo json_encode($response);
	}

	public function Retail()
	{
		$reqHeaders = getallheaders();

		$xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";
		if ($xIncomingCallbackTokenHeader === _XENDIT_CALLBACK_TOKEN) {
			$json_result = file_get_contents('php://input');
			$result = json_decode($json_result, true);

			$expire = new DateTime('now');
			$orderid = $result['external_id'];

			if (!empty($result['payment_id'])) {
				$data['status_paid'] = 200;
				$data['paid_at'] = date('YmdHis');
				$this->db->update('bills', $data, ['order_id' => $orderid]);
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Pembayaran ' . $orderid . ' berhasil.'
				);
			} else if ($result['status'] == 'INACTIVE' || strtotime($result['expiration_date']) < strtotime($expire->format(DateTimeInterface::ISO8601))) {
				$get = $this->db->get_where('bills', ['order_id' => $orderid]);
				if ($get->num_rows() > 0) {
					$this->db->delete('bills', ['order_id' => $orderid]);
				} else {
					return false;
				}

				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Pembayaran ' . $orderid . ' gagal atau kadaluwarsa.'
				);
			} else {
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Billing berhasil dibuat.'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => http_response_code(403)
			);
		}

		echo json_encode($response);
	}

	public function QrCode()
	{
		$reqHeaders = getallheaders();
		$xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";

		if ($xIncomingCallbackTokenHeader === _XENDIT_CALLBACK_TOKEN) {
			$json_result = file_get_contents('php://input');
			$result = json_decode($json_result, true);

			// var_dump($result);
			// die;

			$orderid = $result['qr_code']['external_id'];

			if ($result['status'] == 'COMPLETED') {
				$data['status_paid'] = 200;
				$data['paid_at'] = date('YmdHis');
				$this->db->update('bills', $data, ['order_id' => $orderid]);
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Pembayaran ' . $orderid . ' berhasil.'
				);
			} else if ($result['data']['status'] == 'FAILED' || $result['data']['status'] == 'VOIDED') {
				$get = $this->db->get_where('bills', ['order_id' => $orderid]);
				if ($get->num_rows() > 0) {
					$this->db->delete('bills', ['order_id' => $orderid]);
				} else {
					return false;
				}

				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Pembayaran ' . $orderid . ' gagal atau kadaluwarsa.'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => http_response_code(403)
			);
		}

		echo json_encode($response);
	}
}
