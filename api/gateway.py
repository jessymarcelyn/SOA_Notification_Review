from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
from werkzeug.wrappers import Response
import requests

class GatewayService:
    name = 'gateway'

    TransP_rpc = RpcProxy('transaksi_pembayaran_service')

    # Get berdasarkan id_pesanan
    @http('GET', '/Tpembayaran/IDPesanan/<int:IDPesanan>')
    def get__byIDPesanan(self, request, IDPesanan):
        exist = self.TransP_rpc.get__byIDPesanan(IDPesanan)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # Get berdasarkan id_transaksi
    @http('GET', '/Tpembayaran/IDTransaksi/<int:IDTransaksi>')
    def get__byIDTransaksi(self, request, IDTransaksi):
        exist = self.TransP_rpc.get__byIDTransaksi(IDTransaksi)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # Update berdasarkan id_pesanan (jenis_pembayaran, nama_penyedia)
    @http('PUT', '/Tpembayaran/updateTrans/<int:IDTransaksi>')
    def update__byIDTransaksi(self, request, IDTransaksi):
        exist = self.TransP_rpc.get__byIDTransaksi(IDTransaksi)
        if exist:
            try:
                data = json.loads(request.get_data(as_text=True))
                # timestamp = data.get('timestamp')
                jenis_pembayaran = data.get('jenis')
                nama_penyedia = data.get('nama_penyedia')
                update = self.TransP_rpc.update__byIDTransaksi(IDTransaksi, jenis_pembayaran, nama_penyedia)
                return Response(json.dumps(update), status=200, mimetype='application/json')
            except Exception as e:
                return 500, json.dumps({"error": str(e)})
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    bca_rpc = RpcProxy('transferBCA_service')

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
        
    #PUT ada pembayaran jadi update status = success
    @http('PUT', '/transBCA/<int:idTrans>')
    def pay_trans(self, request, idTrans):
        exist = self.bca_rpc.get_byIDTrans(idTrans)
        if exist :
            api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
            # api_url = f'http://127.0.0.1:8000/Tpembayaran/updateTrans/{idTrans}'
            payload = {
                'jenis': 'Transfer Bank',
                'nama_penyedia': 'BCA'
            }       
            response = requests.put(api_url, json=payload)
            if response.status_code == 200:
                pay = self.bca_rpc.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            else:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    mandiri_rpc = RpcProxy('transferMandiri_service')

    #GET status berdasarkan id_transaksi
    @http('GET', '/transMandiri/status/<int:idTrans>')
    def get_status_byIDTrans(self, request, idTrans):
        exist = self.mandiri_rpc.get_status_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET berdasarkan id_transaksi
    @http('GET', '/transMandiri/<int:idTrans>')
    def get_byIDTrans(self, request, idTrans):
        exist = self.mandiri_rpc.get_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    @http('GET', '/transMandiri/timestamp/<int:idTrans>')
    def get_timestamp_byIDTrans(self, request, idTrans):
        exist = self.mandiri_rpc.get_timestamp_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #POST create (masukin no_rek, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transMandiri')
    def create_trans(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_rek = data.get('no_rek')
            nominal = data.get('nominal')
            va = data.get('VA')
            transaksi = self.mandiri_rpc.create_trans(
                no_rek, nominal, va
            )
            return 200, json.dumps(transaksi)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    #PUT ada pembayaran jadi update status = success
    @http('PUT', '/transMandiri/<int:idTrans>')
    def pay_trans(self, request, idTrans):
        exist = self.mandiri_rpc.get_byIDTrans(idTrans)
        if exist :
            api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
            payload = {
                'jenis': 'Transfer Bank',
                'nama_penyedia': 'BCA'
            }       
            response = requests.put(api_url, json=payload)
            if response.status_code == 200:
                pay = self.mandiri_rpc.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            else:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    