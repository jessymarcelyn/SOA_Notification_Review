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
                status = data.get('status')
                update = self.TransP_rpc.update__byIDTransaksi(IDTransaksi, jenis_pembayaran, nama_penyedia, status)
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
        
    #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transBCA')
    def create_trans(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_telp = data.get('no_telp') #BAKALAN DIGANTI SAMA API GET NO_TELP NYA 
            nominal = data.get('nominal')
            # va = data.get('VA')
            api_url = f'http://localhost:8000//BCA/{no_telp}'
            Response = request.get(api_url)
            if Response.status_code == 200:
                va = Response.json()
                transaksi = self.bca_rpc.create_trans(
                    no_telp, nominal, va
                )
                return 200, json.dumps(transaksi)
            else: 
                return Response(json.dumps('Wrong phone number'), status=404, mimetype='application/json')
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
                'nama_penyedia': 'BCA',
                'status' : 'success'
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
        
    #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transMandiri')
    def create_trans(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_telp = data.get('no_telp')
            nominal = data.get('nominal')
            va = data.get('VA')
            transaksi = self.mandiri_rpc.create_trans(
                no_telp, nominal, va
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
                'nama_penyedia': 'BCA',
                'status' : 'success'
            }       
            response = requests.put(api_url, json=payload)
            if response.status_code == 200:
                pay = self.mandiri_rpc.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            else:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    BBCA_rpc = RpcProxy('BankBCA_service')
    
    @http('GET', '/BCA/<string:noTelp>')
    def getVA (self, request, noTelp):
        exist = self.BBCA_rpc.get_byNoTelp(noTelp)
        va = ''
        if exist:
            va += '123'
            va  += noTelp
            # va.append(str(noTelp))
            return Response(json.dumps(va), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Bank Account is found with this phone number'), status=404, mimetype='application/json')
        
    @http('POST', '/BCA')
    def createBankAcc (self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            nama = data.get('nama')
            no_rek = data.get('no_rek')
            pin = data.get('pin')
            saldo = data.get('saldo')
            no_telp = data.get('no_telp')
            create = self.BBCA_rpc.createBankAcc(nama, no_rek, pin, saldo, no_telp)
            return 200, json.dumps(create)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    @http('GET', '/BCA/Cpin/<string:VA>/<string:pin>')
    def CheckPin (self, request, VA, pin):
        no = VA[3:]
        check = self.BBCA_rpc.CheckPin(no, pin)
        if check: 
            return Response(json.dumps('hhh'), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('Wrong VA or PIN Please try again'), status=404, mimetype='application/json')
    
    BMandiri_RPC = RpcProxy('BankMandiri_service')
    
    @http('GET', '/BCA/<string:noTelp>')
    def getVA (self, request, noTelp):
        exist = self.BMandiri_RPC.get_byNoTelp(noTelp)
        va = ''
        if exist:
            va += '123'
            va  += noTelp
            # va.append(str(noTelp))
            return Response(json.dumps(va), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Bank Account is found with this phone number'), status=404, mimetype='application/json')
        
    @http('POST', '/BCA')
    def createBankAcc (self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            nama = data.get('nama')
            no_rek = data.get('no_rek')
            pin = data.get('pin')
            saldo = data.get('saldo')
            no_telp = data.get('no_telp')
            create = self.BMandiri_RPC.createBankAcc(nama, no_rek, pin, saldo, no_telp)
            return 200, json.dumps(create)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    @http('GET', '/BCA/Cpin/<string:VA>/<string:pin>')
    def CheckPin (self, request, VA, pin):
        no = VA[3:]
        check = self.BMandiri_RPC.CheckPin(no, pin)
        if check: 
            return Response(json.dumps('hhh'), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('Wrong VA or PIN Please try again'), status=404, mimetype='application/json')
            
    
    
