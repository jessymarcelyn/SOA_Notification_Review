from nameko.rpc import rpc
import dependencies

class Transferservice:

    name = 'transferMandiri_service'

    database = dependencies.Database()

    #GET  berdasarkan id_transaksi
    @rpc
    def get_byIDTrans(self, idTrans):
        trans = self.database.get_byIDTrans(idTrans)
        return {
            'code' : 200,
            'data' : trans
        }

    #GET status berdasarkan id_transaksi
    @rpc
    def get_status_byIDTrans(self, idTrans):
        trans = self.database.get_status_byIDTrans(idTrans)
        return {
            'code' : 200,
            'data' : trans
        }
    
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    @rpc
    def get_timestamp_byIDTrans(self, idTrans):
        trans = self.database.get_timestamp_byIDTrans(idTrans)
        return {
            'code' : 200,
            'data' : trans
        }
    
    #POST masukin transaksi ke tabel transaksi transaksi transfer bank
    @rpc
    def create_trans(self, no_rek, nominal, va ):
        trans = self.database.create_trans(no_rek, nominal, va)
        return {
            'code' : 200,
            'data' : trans
        }
    
    @rpc
    def pay_trans(self, idTrans ):
        pay = self.database.pay_trans(idTrans)
        return {
            'code' : 200,
            'data' : pay
        }