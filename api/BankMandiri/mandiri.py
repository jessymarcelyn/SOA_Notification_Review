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