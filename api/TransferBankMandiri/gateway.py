from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
from werkzeug.wrappers import Response

class GatewayService:
    name = 'gateway'

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
    @http('PUT', '/transMandiri/pay/<int:idTrans>')
    def pay_trans(self, request, idTrans):
        exist = self.mandiri_rpc.get_byIDTrans(idTrans)
        if exist :
            pay = self.mandiri_rpc.pay_trans(idTrans)
            return Response(json.dumps(pay), status=200, mimetype='application/json')
        else:
            return Response(json.dumps('No Transaction found with this ID'), status=404, mimetype='application/json')
        
    
