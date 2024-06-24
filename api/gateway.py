from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
from werkzeug.wrappers import Response
import requests

class GatewayService:
    name = 'gateway'

    # TRANSAKSI PEMBAYARAN
    TransP_rpc = RpcProxy('transaksi_pembayaran_service')

    # Get berdasarkan id_pesanan
    @http('GET', '/Tpembayaran/pesanan/<int:IDPesanan>')
    def get__byIDPesananTP(self, request, IDPesanan):
        exist = self.TransP_rpc.get__byIDPesanan(IDPesanan)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # Get berdasarkan id_transaksi
    @http('GET', '/Tpembayaran/transaksi/<int:IDTransaksi>')
    def get__byIDTransaksiTP(self, request, IDTransaksi):
        exist = self.TransP_rpc.get__byIDTransaksi(IDTransaksi)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # Update berdasarkan id_transaksi (jenis_pembayaran, nama_penyedia)
    @http('PUT', '/Tpembayaran/transaksi/<int:IDTransaksi>')
    def update__byIDTransaksiTP(self, request, IDTransaksi):
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
    
    #Create transaksi_pembayaran
    @http('POST', '/Tpembayaran')
    def create_pembayaranTP(self, request):
        data = json.loads(request.get_data(as_text=True))
        id_pesanan = data.get('id_pesanan')
        id_pesanan2 = data.get('id_pesanan2') 
        total_transaksi = data.get('total_transaksi')
        
        pembayaran = self.TransP_rpc.create_pembayaran(id_pesanan, id_pesanan2, total_transaksi)

        return pembayaran['code'],json.dumps(pembayaran['data'])
    
    #update status berdasarkan id_pesanan
    @http('PUT', '/Tpembayaran/pesanan/<int:id_pesanan>/status/<string:status>')
    def update_status_pembayaranTP(self, request, id_pesanan, status):
        transaksi = self.TransP_rpc.update_status_pembayaran(id_pesanan, status)
        if transaksi :
            return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return transaksi['code'],json.dumps(transaksi['data'])
    
    #update id_transaksi berdasarkan id_pesanan
    @http('PUT', '/Tpembayaran/pesanan/<int:id_pesanan>/transaksi/<string:id_transaksi>')
    def update_idTransaksiTP(self, request, id_pesanan, id_transaksi):
        transaksi = self.TransP_rpc.update_idTransaksi(id_pesanan, id_transaksi)
        if transaksi :
            return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return transaksi['code'],json.dumps(transaksi['data'])
    
    #update id_transaksi, jenis_pembayaran, nama_penyedia, status(ongoing), timestamp(otomatis) berdasarkan id_pesanan
    @http('PUT', '/Tpembayaran/pesanan/<int:id_pesanan>')
    def update_pembayaranTP(self, request, id_pesanan):
        data = json.loads(request.get_data(as_text=True))
        id_transaksi = data.get('id_transaksi')
        jenis_pembayaran = data.get('jenis_pembayaran') 
        nama_penyedia = data.get('nama_penyedia')
    
        transaksi = self.TransP_rpc.update_pembayaran(id_pesanan, id_transaksi, jenis_pembayaran, nama_penyedia)
        if transaksi :
            return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return transaksi['code'],json.dumps(transaksi['data'])
    
    # # TRANSFER BCA
    # bca_rpc = RpcProxy('transferBCA_service')

    # #GET status berdasarkan id_transaksi
    # @http('GET', '/transBCA/status/<int:idTrans>')
    # def get_status_byIDTransTBCA(self, request, idTrans):
    #     exist = self.bca_rpc.get_status_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #GET berdasarkan id_transaksi
    # @http('GET', '/transBCA/<int:idTrans>')
    # def get_byIDTransTBCA(self, request, idTrans):
    #     exist = self.bca_rpc.get_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    # @http('GET', '/transBCA/timestamp/<int:idTrans>')
    # def get_timestamp_byIDTransTBCA(self, request, idTrans):
    #     exist = self.bca_rpc.get_timestamp_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    # @http('POST', '/transBCA')
    # def create_transTBCA(self, request):
    #     try:
    #         data = json.loads(request.get_data(as_text=True))
    #         no_telp = data.get('no_telp') #BAKALAN DIGANTI SAMA API GET NO_TELP NYA 
    #         nominal = data.get('nominal')
    #         # va = data.get('VA')
    #         api_url = f'http://localhost:8000/BCA/{no_telp}'
    #         Response = requests.get(api_url)
    #         if Response.status_code == 200:
    #             va = Response.json()
    #             transaksi = self.bca_rpc.create_trans(
    #                 no_telp, nominal, va
    #             )
    #             return 200, json.dumps(transaksi)
    #         else: 
    #             return Response(json.dumps('Wrong phone number'), status=404, mimetype='application/json')
    #     except Exception as e:
    #         return 500, json.dumps({"error": str(e)})
        
    # #PUT ada pembayaran jadi update status = success
    # @http('PUT', '/transBCA/<int:idTrans>')
    # def pay_transTBCA(self, request, idTrans):
    #     exist = self.bca_rpc.get_byIDTrans(idTrans)
    #     if exist :
    #         api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
    #         # api_url = f'http://127.0.0.1:8000/Tpembayaran/updateTrans/{idTrans}'
    #         payload = {
    #             'jenis': 'Transfer Bank',
    #             'nama_penyedia': 'BCA',
    #             'status' : 'success'
    #         }       
    #         response = requests.put(api_url, json=payload)
    #         if response.status_code == 200:
    #             pay = self.bca_rpc.pay_trans(idTrans)
    #             return Response(json.dumps(pay), status=200, mimetype='application/json')
    #         else:
    #             return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
    
    #TRANSFER MANDIRI
    # mandiri_rpc = RpcProxy('transferMandiri_service')

    # #GET status berdasarkan id_transaksi
    # @http('GET', '/transMandiri/status/<int:idTrans>')
    # def get_status_byIDTransTMandiri(self, request, idTrans):
    #     exist = self.mandiri_rpc.get_status_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #GET berdasarkan id_transaksi
    # @http('GET', '/transMandiri/<int:idTrans>')
    # def get_byIDTransTMandiri(self, request, idTrans):
    #     exist = self.mandiri_rpc.get_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    # @http('GET', '/transMandiri/timestamp/<int:idTrans>')
    # def get_timestamp_byIDTransTMandiri(self, request, idTrans):
    #     exist = self.mandiri_rpc.get_timestamp_byIDTrans(idTrans)
    #     if exist:
    #         return Response(json.dumps(exist), status=200, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    # #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    # @http('POST', '/transMandiri')
    # def create_transTMandiri(self, request):
    #     try:
    #         data = json.loads(request.get_data(as_text=True))
    #         no_telp = data.get('no_telp')
    #         nominal = data.get('nominal')
    #         api_url = f'http://localhost:8000/Mandiri/{no_telp}'
    #         Response = requests.get(api_url)
    #         if Response.status_code == 200:
    #             va = Response.json()
    #             transaksi = self.mandiri_rpc.create_trans(
    #                 no_telp, nominal, va
    #             )
    #             return 200, json.dumps(transaksi)
    #         else: 
    #             return Response(json.dumps('Wrong phone number'), status=404, mimetype='application/json')
    #     except Exception as e:
    #         return 500, json.dumps({"error": str(e)})
        
    # #PUT ada pembayaran jadi update status = success
    # @http('PUT', '/transMandiri/<int:idTrans>')
    # def pay_transTMandiri(self, request, idTrans):
    #     exist = self.mandiri_rpc.get_byIDTrans(idTrans)
    #     if exist :
    #         api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
    #         payload = {
    #             'jenis': 'Transfer Bank',
    #             'nama_penyedia': 'BCA',
    #             'status' : 'success'
    #         }       
    #         response = requests.put(api_url, json=payload)
    #         if response.status_code == 200:
    #             pay = self.mandiri_rpc.pay_trans(idTrans)
    #             return Response(json.dumps(pay), status=200, mimetype='application/json')
    #         else:
    #             return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
    #     else:
    #         return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #BANK BCA
    BBCA_rpc = RpcProxy('BankBCA_service')
    
    @http('GET', '/BCA/<string:noTelp>')
    def getVABCA(self, request, noTelp):
        exist = self.BBCA_rpc.get_byNoTelp(noTelp)
        va = ''
        if exist:
            va += '122'
            va  += noTelp
            # va.append(str(noTelp))
            return Response(json.dumps(va), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Bank Account is found with this phone number'), status=404, mimetype='application/json')
        
    @http('POST', '/BCA')
    def createBankAccBCA(self, request):
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
        
    @http('GET', '/BCA/pin/<string:VA>/<string:pin>')
    def CheckPinBCA(self, request, VA, pin):
        no = VA[3:]
        check = self.BBCA_rpc.CheckPin(no, pin)
        if check: 
            return Response(json.dumps('hhh'), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('Wrong VA or PIN Please try again'), status=404, mimetype='application/json')

    #GET status berdasarkan id_transaksi
    @http('GET', '/transBCA/status/<int:idTrans>')
    def get_status_byIDTransTBCA(self, request, idTrans):
        exist = self.BBCA_rpc.get_status_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET berdasarkan id_transaksi
    @http('GET', '/transBCA/<int:idTrans>')
    def get_byIDTransTBCA(self, request, idTrans):
        exist = self.BBCA_rpc.get_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    @http('GET', '/transBCA/timestamp/<int:idTrans>')
    def get_timestamp_byIDTransTBCA(self, request, idTrans):
        exist = self.BBCA_rpc.get_timestamp_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transBCA')
    def create_transTBCA(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_telp = data.get('no_telp') #BAKALAN DIGANTI SAMA API GET NO_TELP NYA 
            nominal = data.get('nominal')
            # va = data.get('VA')
            api_url = f'http://localhost:8000/BCA/{no_telp}'
            Response = requests.get(api_url)
            if Response.status_code == 200:
                va = Response.json()
                transaksi = self.BBCA_rpc.create_trans(
                    no_telp, nominal, va
                )
                return 200, json.dumps(transaksi)
            else: 
                return Response(json.dumps('Wrong phone number'), status=404, mimetype='application/json')
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    #PUT ada pembayaran jadi update status = success
    @http('PUT', '/transBCA/<int:idTrans>')
    def pay_transTBCA(self, request, idTrans):
        exist = self.BBCA_rpc.get_byIDTrans(idTrans)
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
                pay = self.BBCA_rpc.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            else:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    
    #BANK MANDIRI
    BMandiri_RPC = RpcProxy('BankMandiri_service')
    
    @http('GET', '/Mandiri/<string:noTelp>')
    def getVAMandiri(self, request, noTelp):
        exist = self.BMandiri_RPC.get_byNoTelp(noTelp)
        va = ''
        if exist:
            va += '126'
            va  += noTelp
            # va.append(str(noTelp))
            return Response(json.dumps(va), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Bank Account is found with this phone number'), status=404, mimetype='application/json')
        
    @http('POST', '/Mandiri')
    def createBankAccMandiri(self, request):
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
        
    @http('GET', '/Mandiri/pin/<string:VA>/<string:pin>')
    def CheckPinMandiri(self, request, VA, pin):
        no = VA[3:]
        check = self.BMandiri_RPC.CheckPin(no, pin)
        if check: 
            return Response(json.dumps('hhh'), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('Wrong VA or PIN Please try again'), status=404, mimetype='application/json')

    #GET status berdasarkan id_transaksi
    @http('GET', '/transMandiri/status/<int:idTrans>')
    def get_status_byIDTransTMandiri(self, request, idTrans):
        exist = self.BMandiri_RPC.get_status_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET berdasarkan id_transaksi
    @http('GET', '/transMandiri/<int:idTrans>')
    def get_byIDTransTMandiri(self, request, idTrans):
        exist = self.BMandiri_RPC.get_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    @http('GET', '/transMandiri/timestamp/<int:idTrans>')
    def get_timestamp_byIDTransTMandiri(self, request, idTrans):
        exist = self.BMandiri_RPC.get_timestamp_byIDTrans(idTrans)
        if exist:
            return Response(json.dumps(exist), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #POST create (masukin no_telp, nominal, status = ongoing, VA) di tabel transaksi transfer bank
    @http('POST', '/transMandiri')
    def create_transTMandiri(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            no_telp = data.get('no_telp')
            nominal = data.get('nominal')
            api_url = f'http://localhost:8000/Mandiri/{no_telp}'
            Response = requests.get(api_url)
            if Response.status_code == 200:
                va = Response.json()
                transaksi = self.BMandiri_RPC.create_trans(
                    no_telp, nominal, va
                )
                return 200, json.dumps(transaksi)
            else: 
                return Response(json.dumps('Wrong phone number'), status=404, mimetype='application/json')
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        
    #PUT ada pembayaran jadi update status = success
    @http('PUT', '/transMandiri/<int:idTrans>')
    def pay_transTMandiri(self, request, idTrans):
        exist = self.BMandiri_RPC.get_byIDTrans(idTrans)
        if exist :
            api_url = f'http://localhost:8000/Tpembayaran/updateTrans/{idTrans}'
            payload = {
                'jenis': 'Transfer Bank',
                'nama_penyedia': 'BCA',
                'status' : 'success'
            }       
            response = requests.put(api_url, json=payload)
            if response.status_code == 200:
                pay = self.BMandiri_RPC.pay_trans(idTrans)
                return Response(json.dumps(pay), status=200, mimetype='application/json')
            else:
                return Response(json.dumps({'error': 'Failed to update transaction'}), status=response.status_code, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    #GOPAY
    gopay_rpc = RpcProxy('gopay_service')

    @http('POST', '/gopay') #cek nomor telepon, return idtransaksi
    def post_pembayaran_gopay(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.gopay_rpc.insert_transaksi(data['no_telp'], data['nominal'])
        return json.dumps(pembayaran)
         
    @http('GET', '/gopay/status/<string:id_transaksi>') #return status pembayaran
    def get_status_pembayaran_by_id_transaksi_gopay(self, request, id_transaksi):
        pembayaran = self.gopay_rpc.get_status_transaksi(id_transaksi)
        return json.dumps(pembayaran)
    
    @http('PUT', '/gopay/pembayaran') #check pin dan check saldo
    def bayar_gopay(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.gopay_rpc.bayar(data['id_transaksi'], data['pin'])
        return json.dumps(pembayaran)
    
    @http('GET', '/gopay/timestamp/<string:id_transaksi>')
    def get_timestamp_by_id_transaksi_gopay(self, request, id_transaksi):
        timestamp = self.gopay_rpc.get_timestamp(id_transaksi)
        return json.dumps(timestamp)
    
    # OVO
    ovo_rpc = RpcProxy('ovo_service')

    @http('POST', '/ovo') #cek nomor telepon, return idtransaksi
    def post_pembayaran_ovo(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.ovo_rpc.insert_transaksi(data['no_telp'], data['nominal'])
        return json.dumps(pembayaran)
         
    @http('GET', '/ovo/status/<string:id_transaksi>') #return status pembayaran
    def get_status_pembayaran_by_id_transaksi_ovo(self, request, id_transaksi):
        pembayaran = self.ovo_rpc.get_status_transaksi(id_transaksi)
        return json.dumps(pembayaran)
    
    @http('PUT', '/ovo/pembayaran') #check pin dan check saldo
    def bayar_ovo(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.ovo_rpc.bayar(data['id_transaksi'], data['pin'])
        return json.dumps(pembayaran)
    
    @http('GET', '/ovo/timestamp/<string:id_transaksi>')
    def get_timestamp_by_id_transaksi_ovo(self, request, id_transaksi):
        timestamp = self.ovo_rpc.get_timestamp(id_transaksi)
        return json.dumps(timestamp)
    
    # KARTU KREDIT
    kartu_rpc = RpcProxy('kartu_service')
    
    @http('POST', '/kartu_kredit')
    def create_kartu(self, request):
        data = json.loads(request.get_data(as_text=True))
        kartu  = self.kartu_rpc.create_kartu(data['nama'], data['nomer_kartu'], data['cvv'], data['expired_year'], data['expired_month'], data['limit_maks'], data['limit_terpakai'], data['status'])
        return json.dumps(kartu)
    
    #cek apakah kartu valid dan bisa digunakan
    @http('GET', '/kartu_kredit/<string:nomer_kartu>')
    def get_nomer_kartu(self, request, nomer_kartu):
        kartu = self.kartu_rpc.get_nomer_kartu(nomer_kartu)

        return kartu['code'],json.dumps(kartu['data'])
    
    #cek apakah nomer kartu dan cvv sesuai
    # @http('GET', '/kartu_kredit/<string:nomer_kartu>/cvv/<string:cvv>')
    # def cek_card_cvv(self, request, nomer_kartu, cvv):
    #     kartu = self.kartu_rpc.cek_card_cvv(nomer_kartu,cvv)
    #     if kartu:
    #         response = {'valid': True}
    #     else:
    #         response = {'valid': False}
    #     return Response(json.dumps(response), mimetype='application/json')
    
    #cek apakah inputan user sudah sesuai, apakah limit tidak lebih dan blm expired
    @http('GET', '/kartu_kredit/<string:nomer_kartu>/cvv/<string:cvv>/nama/<string:nama>/expired_month/<int:month>/expired_year/<int:year>/nominal/<int:nominal>')
    def cek_card_cvv_http(self, request, nomer_kartu, cvv, nama, month, year, nominal):
        kartu = self.kartu_rpc.cek_card_cvv(nomer_kartu, cvv, nama, month, year, nominal)
        
        if kartu.get('status', False):
            return kartu.get('code', 200), json.dumps(kartu)
        else:
            return kartu.get('code', 500), json.dumps(kartu)
    
    #create skalian buat otp
    @http('POST', '/kartu_kredit/transaksi/')
    def create_transaksi_kartu(self, request):
        data = json.loads(request.get_data(as_text=True))
        transaksi  = self.kartu_rpc.create_transaksi(data['nomer_kartu'], data['nominal'], data['status'])
        return transaksi['code'],json.dumps(transaksi['data'])
    
    #get OTP berdasarkan id_transaksi
    # @http('GET', '/kartu_kredit/transaksi/<int:id_transaksi>')
    # def get_otp(self, request, id_transaksi):
    #     cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
    #     if cek_id_transaksi:
    #         otp = self.kartu_rpc.get_otp(id_transaksi)
    #         if otp :
    #             return otp['code'],json.dumps(otp['data'])
    #     else:
    #         return cek_id_transaksi['code'],json.dumps(cek_id_transaksi['data'])
    
    # get all data berdasarkan id_transaksi
    @http('GET', '/kartu_kredit/transaksi/<int:id_transaksi>')
    def get_data_Tkartu(self, request, id_transaksi):
        cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if cek_id_transaksi:
            data = self.kartu_rpc.get_data_Tkartu(id_transaksi)
            if data :
                return data['code'],json.dumps(data['data'])
        else:
            return cek_id_transaksi['code'],json.dumps(cek_id_transaksi['data'])
        
    # cek OTP berdasarkan id_transaksi dan otp user
    @http('GET', '/kartu_kredit/transaksi/<int:id_transaksi>/otp/<string:otp>')
    def cek_otp(self, request, id_transaksi, otp):
        cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if cek_id_transaksi:
            otp = self.kartu_rpc.cek_otp(id_transaksi, otp)
            if otp :
                return otp['code'],json.dumps(otp['data'])
        else:
            return cek_id_transaksi['code'],json.dumps(cek_id_transaksi['data'])
        
    # Update timestamp_otp dan otp berdasarkan id_transaksi 
    # @http('PUT', '/kartu_kredit/transaksi/<string:id_transaksi>')
    # def change_otp(self, request, id_transaksi):
    #     kartu = self.kartu_rpc.cek_id_transaksi(id_transaksi)
    #     if kartu:
    #         transaksi = self.kartu_rpc.change_otp(id_transaksi)
    #         return transaksi['code'],json.dumps(transaksi['data'])
    #     else:
    #         return kartu['code'],json.dumps(kartu['data'])
    
    # Update attempt
    @http('PUT', '/kartu_kredit/transaksi/<string:id_transaksi>')
    def update_attempt(self, request, id_transaksi):
        kartu = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if kartu:
            transaksi = self.kartu_rpc.update_attempt(id_transaksi)
            return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return kartu['code'],json.dumps(kartu['data'])
    
    #update status dan limit berdasarkan id_transaksi
    @http('PUT', '/kartu_kredit/transaksi/<int:id_transaksi>/status/<string:status>')
    def update_status_transaksi_kartu(self, request, id_transaksi, status):
        cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if cek_id_transaksi:
            transaksi = self.kartu_rpc.update_status_transaksi(id_transaksi, status)
            if transaksi :
                return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return cek_id_transaksi['code'],json.dumps(cek_id_transaksi['data'])
        
    
    # NOTIFIKASI
    notif_rpc = RpcProxy('notif_service')

    #GET notif berdasarkan id_notif
    @http('GET', '/notif/<int:idNotif>')
    def get_notif_ID(self, request, idNotif):
        notif = self.notif_rpc.get_notif_ID(idNotif)
        # return json.dumps(notif)
        if notif:
            return Response(json.dumps(notif), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Notification found with this ID'), status=404, mimetype='application/json')


    #GET semua notif
    @http('GET', '/notif')
    def get_rooms(self, request):
        notifs = self.notif_rpc.get_all_notif()
        return json.dumps(notifs)

    #GET notif berdasarkan id user
    @http('GET', '/notif/user/<int:idUser>')
    def get_notif_IDUser(self, request, idUser):
        notifs = self.notif_rpc.get_notif_IDUser(idUser)
        # return json.dumps(notifs)
        if notifs:
            return Response(json.dumps(notifs), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Notification found with this User ID'), status=404, mimetype='application/json')
        
    #GET notif berdasarkan id user
    @http('GET', '/notif/user/<int:idUser>/<string:notifTypes>')
    def get_notif_IDUser_notifTypes(self, request, idUser, notifTypes):
        notifs = self.notif_rpc.get_notif_IDUser_notifType(idUser, notifTypes)
        # return json.dumps(notifs)
        if notifs:
            return Response(json.dumps(notifs), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Notification found with this User ID'), status=404, mimetype='application/json')

    #PUT berdasarkan id_notif 
    # @http('PUT', '/notif/<int:idNotif>')
    # def update_notif_ID(self, request, idNotif):
    #     # data = json.loads(request.get_data(as_text=True))
    #     notif = self.notif_rpc.update_notif_ID(idNotif)
    #     return notif['code'],json.dumps(notif['data'])
    
    #Delete berdasarkan id_notif
    @http('DELETE', '/notif/<int:idNotif>')
    def delete_notif(self, request, idNotif):
        notif = self.notif_rpc.delete_notif(idNotif)
        return notif['code'],json.dumps(notif['data'])

    #GET notif berdasarkan status
    @http('GET', '/notif/status/<int:status>')
    def get_notif_status(self, request, status):
        notifs = self.notif_rpc.get_notif_status(status)
        return json.dumps(notifs)
    
    #GET notif berdasarkan tipe 
    @http('GET', '/notif/tipe/<string:tipe_notif>')
    def get_notif_type(self, request, tipe_notif):
        notifs = self.notif_rpc.get_notif_type(tipe_notif)
        return json.dumps(notifs)
    
    #GET notif berdasarkan judul
    @http('GET', '/notif/judul/<string:judul>')
    def get_notif_judul(self, request, judul):
        notifs = self.notif_rpc.get_notif_judul(judul)
        return json.dumps(notifs)
    
    # GET notif berdasarkan timestamp announce
    @http('GET', '/notif/timestampA/<string:timestamp>')
    def get_notif_timestampA(self, request, timestamp):
        notifs = self.notif_rpc.get_notif_timestampA(str(timestamp))  # Convert datetime to string
        return json.dumps(notifs)
    
    # GET notif berdasarkan timestamp masuk
    @http('GET', '/notif/timestampM/<string:timestamp>')
    def get_notif_timestampM(self, request, timestamp):
        notifs = self.notif_rpc.get_notif_timestampM(str(timestamp))  # Convert datetime to string
        return json.dumps(notifs)
    
    # create a new notification
    @http('POST', '/notif')
    def add_notif(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            id_user = data.get('id_user')
            id_pesanan = data.get('id_pesanan')
            tipe_notif = data.get('tipe_notif')
            judul = data.get('judul')
            deskripsi = data.get('deskripsi')
            timestamp_masuk = data.get('timestamp_masuk')
            status = data.get('status')
            link = data.get('link')  # Use get() method to get optional fields
            
            # Call add_notif method with optional fields
            notif = self.notif_rpc.add_notif(
                id_user, id_pesanan, tipe_notif, judul, deskripsi, timestamp_masuk, status, link
            )
            return 200, json.dumps(notif)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
        

    
    @http('PUT', '/notif/<int:idNotif>')
    def update_notif_status(self,request, idNotif):
        notifs = self.notif_rpc.update_notif_status(idNotif)
        return json.dumps(notifs)
    
    @http('PUT', '/notif/link/<int:idNotif>')
    def update_notif_link(self,request, idNotif):
        notifs = self.notif_rpc.update_notif_link(idNotif)
        return json.dumps(notifs)
    
    @http('PUT', '/notif/pesanan/<int:id_pesanan>')
    def update_notif_link_pesanan(self,request, id_pesanan):
        data = json.loads(request.get_data(as_text=True))
        notifs = self.notif_rpc.update_notif_link_pesanan(id_pesanan, data['judul'])
        return json.dumps(notifs)
    