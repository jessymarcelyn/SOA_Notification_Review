from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
from werkzeug.wrappers import Response

from digitalPayment.gateway import bayar

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
        
    # Update berdasarkan id_pesanan (timestamp, jenis_pembayaran, nama_penyedia)
    @http('PUT', '/Tpembayaran/updateTrans/<int:IDTransaksi>')
    def update__byIDTransaksi(self, request, IDTransaksi):
        exist = self.TransP_rpc.get__byIDTransaksi(IDTransaksi)
        if exist:
            try:
                data = json.loads(request.get_data(as_text=True))
                # timestamp = data.get('timestamp')
                jenis_pembayaran = data.get('jenis')
                nama_penyedia = data.get('nama_penyedia')
                # no_kartu = data.get('no_kartu')
                # cvv = data.get('cvv')
                # nominal = data.get('nominal')
                # no_telp = data.get('no_telp')
                # pin = data.get('pin')
                # limit = data.get('limit')
                # if timestamp or jenis_pembayaran or nama_penyedia is None:
                #     return Response(json.dumps('Missing Value. Timestamp, jenis_pembayaran, nama_penyedia canot be Null.'), status=404, mimetype='application/json')
                # else:
                #     if no_kartu or cvv or nominal is not None:
                #         update = self.TransP_rpc.update__byIDTransaksi(IDTransaksi, timestamp, jenis_pembayaran, nama_penyedia)
                #     elif no_telp or pin or limit is not None:

                    #     update = self.TransP_rpc.update__byIDTransaksi(IDTransaksi, timestamp, jenis_pembayaran, nama_penyedia)
                    # else:
                    #     return Response(json.dumps('Missing Value! Please make sure you have insert all the needed value'), status=404, mimetype='application/json')
                update = self.TransP_rpc.update__byIDTransaksi(IDTransaksi, jenis_pembayaran, nama_penyedia)
                return Response(json.dumps(update), status=200, mimetype='application/json')
            except Exception as e:
                return 500, json.dumps({"error": str(e)})
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        