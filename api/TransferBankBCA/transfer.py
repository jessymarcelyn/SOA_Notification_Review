from nameko.rpc import rpc
import dependencies

class Notifservice:

    name = 'transfer_service'

    database = dependencies.Database()

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