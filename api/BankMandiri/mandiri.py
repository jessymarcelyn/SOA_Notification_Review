from nameko.rpc import rpc
import dependencies

class BankMandiriService:

    name = 'BankMandiri_service'

    database = dependencies.Database()

    #Get dengan no_telp tapi yang di return lagi hanya no_telp karena ini untuk pengecekan
    @rpc
    def get_byNoTelp(self, noTelp):
        get = self.database.get_byNoTelp(noTelp)
        return {
            'code' : 200,
            'data' : get
        }
    
    @rpc
    def createBankAcc(self, nama, no_rek, pin, saldo, no_telp):
        create = self.database.createBankAcc(nama, no_rek, pin, saldo, no_telp)
        return {
            'code' : 200,
            'data' : create
        }
    
    @rpc
    def CheckPin(self, no ,pin):
        check = self.database.CheckPin(no, pin)
        if check is True:
             return {
            'code' : 200,
            'data' : check
        }
        else:
            return {
                'code' : 404,
                'data' : check
            }
    
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
    def create_trans(self, no_telp, nominal, va ):
        trans = self.database.create_trans(no_telp, nominal, va)
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