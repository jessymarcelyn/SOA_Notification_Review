import json

from nameko.rpc import RpcProxy
from nameko.web.handlers import http
from werkzeug.exceptions import BadRequest
from werkzeug.wrappers import Response

class GatewayPaymentService:
    name = 'gateway'

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
    def create_transaksi(self, request):
        data = json.loads(request.get_data(as_text=True))
        transaksi  = self.kartu_rpc.create_transaksi(data['nomer_kartu'], data['nominal'], data['status'])
        return transaksi['code'],json.dumps(transaksi['data'])
    
    #get OTP berdasarkan id_transaksi
    @http('GET', '/kartu_kredit/transaksi/<int:id_transaksi>')
    def get_otp(self, request, id_transaksi):
        cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if cek_id_transaksi:
            otp = self.kartu_rpc.get_otp(id_transaksi)
            if otp :
                return otp['code'],json.dumps(otp['data'])
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
    @http('PUT', '/kartu_kredit/transaksi/<string:id_transaksi>')
    def change_otp(self, request, id_transaksi):
        kartu = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if kartu:
            transaksi = self.kartu_rpc.change_otp(id_transaksi)
            return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return kartu['code'],json.dumps(kartu['data'])
    
    #update status dan limit berdasarkan id_transaksi
    @http('PUT', '/kartu_kredit/transaksi/<int:id_transaksi>/status/<string:status>')
    def update_status_transaksi(self, request, id_transaksi, status):
        cek_id_transaksi = self.kartu_rpc.cek_id_transaksi(id_transaksi)
        if cek_id_transaksi:
            transaksi = self.kartu_rpc.update_status_transaksi(id_transaksi, status)
            if transaksi :
                return transaksi['code'],json.dumps(transaksi['data'])
        else:
            return cek_id_transaksi['code'],json.dumps(cek_id_transaksi['data'])
        