import json

from nameko.rpc import RpcProxy
from nameko.web.handlers import http


class GatewayPaymentService:
    name = 'gateway'

    payment_rpc = RpcProxy('payment_service')
    
    @http('GET', '/pembayaran/idpesan/<int:id_pesanan>')
    def get_pembayaran_by_id_pemesanan(self, request, id_pesanan):
        pembayaran = self.payment_rpc.get_pembayaran_by_id_pesanan(id_pesanan)
        return json.dumps(pembayaran)
    
    @http('GET', '/pembayaran/idpembayaran/<int:id_pembayaran>')
    def get_pembayaran_by_id_pembayaran(self, request, id_pembayaran):
        pembayaran = self.payment_rpc.get_pembayaran_by_id_pembayaran(id_pembayaran)
        return json.dumps(pembayaran)
    
    @http('GET', '/pembayaran/iduser/<int:id_user>')
    def get_all_pembayaran_by_id_user(self, request, id_user):
        pembayaran = self.payment_rpc.get_all_pembayaran_by_id_user(id_user)
        return json.dumps(pembayaran)

    
    @http('GET', '/pembayaran')
    def get_all_pembayaran(self, request):
        pembayaran = self.payment_rpc.get_all_pembayaran()
        return json.dumps(pembayaran)
        
    @http('GET', '/pembayaran/jenis_pembayaran/<string:jenis_pembayaran>')
    def get_all_pembayaran_by_jenis_pembayaran(self, request, jenis_pembayaran):
        pembayaran = self.payment_rpc.get_all_pembayaran_by_jenis_pembayaran(jenis_pembayaran)
        return json.dumps(pembayaran)
     
    @http('POST', '/pembayaran')
    def post_pembayaran(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran  = self.payment_rpc.insert_pembayaran(data['id_pesanan'], data['id_user'], data['jenis_pembayaran'], data['sub_total'], data['pajak'], data['total_bayar'], data['nama_penyedia'], data['nomer_kartu'], data['nomer_rekening'], data['nomer_telp'])
        return json.dumps(pembayaran)