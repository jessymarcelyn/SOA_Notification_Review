import json

from nameko.rpc import RpcProxy
from nameko.web.handlers import http


class GatewayPaymentService:
    name = 'gateway'

    ovo_rpc = RpcProxy('ovo_service')

    # @http('GET', '/gopay/no_telp/<string:no_telp>')
    # def get_no_telp(self, request, no_telp):
    #     pembayaran = self.ovo_rpc.get_no_telp()
    #     return json.dumps(pembayaran)
    
    @http('POST', '/gopay') #cek nomor telepon, return idtransaksi
    def post_pembayaran(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.ovo_rpc.insert_transaksi(data['no_telp'], data['nominal'])
        return json.dumps(pembayaran)
         
    @http('GET', '/gopay/status/<string:id_transaksi>') #return status pembayaran
    def get_status_pembayaran_by_id_transaksi(self, request, id_transaksi):
        pembayaran = self.ovo_rpc.get_status_transaksi(id_transaksi)
        return json.dumps(pembayaran)
    
    @http('PUT', '/gopay/bayar') #check pin dan check saldo
    def bayar(self, request):
        data = json.loads(request.get_data(as_text=True))
        pembayaran = self.ovo_rpc.bayar(data['id_transaksi'], data['pin'])
        return json.dumps(pembayaran)
    
    @http('GET', '/gopay/timestamp/<string:id_transaksi>')
    def get_timestamp_by_id_transaksi(self, request, id_transaksi):
        timestamp = self.ovo_rpc.get_timestamp(id_transaksi)
        return json.dumps(timestamp)
    