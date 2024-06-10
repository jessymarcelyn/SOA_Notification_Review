from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
import requests
from werkzeug.wrappers import Response

# from TransaksiPembayaran.gateway import update__byIDTransaksi

class GatewayService:
    name = 'gateway'

    bca_rpc = RpcProxy('transfer_service')

    #GET status berdasarkan id_transaksi
    @http('GET', '/transBCA/status/<int:idTrans>')
    def get_status_byIDTrans(self, request, idTrans):
        exist = self.bca_rpc.get_status_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET berdasarkan id_transaksi
    @http('GET', '/transBCA/<int:idTrans>')
    def get_byIDTrans(self, request, idTrans):
        exist = self.bca_rpc.get_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    @http('GET', '/transBCA/timestamp/<int:idTrans>')
    def get_timestamp_byIDTrans(self, request, idTrans):
        exist = self.bca_rpc.get_timestamp_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #POST create (masukin no_rek, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transBCA')
    def create_trans(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_rek = data.get('no_rek')
            nominal = data.get('nominal')
            va = data.get('VA')
            transaksi = self.bca_rpc.create_trans(
                no_rek, nominal, va
            )
            return 200, json.dumps(transaksi)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    # #PUT ada pembayaran jadi update status = success
    # @http('PUT', '/transBCA/pay/<int:idTrans>')
    # def pay_trans(self, request, idTrans):
    #     exist = self.bca_rpc.get_byIDTrans(idTrans)
    #     if exist :
    #         # update__byIDTransaksi(idTrans,'Transfer Bank', 'BCA') belum fix
    #         # api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
    #         api_url = f'http://127.0.0.1:8000/Tpembayaran/updateTrans/{idTrans}'
    #         payload = {
    #             'jenis': 'Transfer Bank',
    #             'nama_penyedia': 'BCA'
    #         }       
    #         # Make the HTTP PUT request
    #         response = requests.put(api_url, json=payload)
            
    #     #     return Response(json.dumps(pay), status=200, mimetype='application/json')
    #     # else:
    #     #     return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
    #                 # Check the response status and return appropriate content
    #         if response.status_code == 200:
    #             pay = self.bca_rpc.pay_trans(idTrans)

    #             # return Response(response.text, status=200, mimetype='application/json')
    #             return Response(json.dumps(pay), status=200, mimetype='application/json')

    #         elif response.status_code == 404:
    #             return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
import logging  # Import modul logging

# Inisialisasi logger
logger = logging.getLogger(__name__)

# PUT: Jika ada pembayaran, update status menjadi 'success'
@http('PUT', '/transBCA/pay/<int:idTrans>')
def pay_trans(self, request, idTrans):
    exist = self.bca_rpc.get_byIDTrans(idTrans)
    if exist :
        api_url = f'http://127.0.0.1:8000/Tpembayaran/updateTrans/{idTrans}'
        payload = {
            'jenis': 'Transfer Bank',
            'nama_penyedia': 'BCA'
        }
        
        try:
            # Logging sebelum pemanggilan API
            logger.info(f'Making PUT request to {api_url} with payload: {payload}')
            
            # Make the HTTP PUT request
            response = requests.put(api_url, json=payload)
            
            # Logging setelah pemanggilan API
            logger.info(f'Response from API: {response.status_code}, {response.text}')
            
            if response.status_code == 200:
                pay = self.bca_rpc.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            elif response.status_code == 404:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
            else: 
                return 500, json.dumps({"error": "Unexpected error occurred"})
        except Exception as e:
            # Logging jika terjadi kesalahan saat pemanggilan API
            logger.error(f'Error during API request: {str(e)}')
            return 500, json.dumps({"error": str(e)})
    else:
        return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
