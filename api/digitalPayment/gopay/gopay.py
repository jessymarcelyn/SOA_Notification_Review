from nameko.rpc import rpc
import dependencies
 


class PaymentService:

    name = 'gopay_service'

    database = dependencies.Database()

    @rpc
    def hello(self):
        return "Hello,!"
    
    @rpc
    def get_no_telp(self, no_telp):
        boolean = self.database.get_no_telp(no_telp)
        return boolean


    @rpc
    def insert_transaksi(self, no_telp, nominal):
        boolean = self.database.get_no_telp(no_telp)
        if boolean == True:
            id_transaksi = self.database.insert_transaksi(no_telp, nominal)
            return id_transaksi
        else:
            return False
    
    @rpc
    def bayar(self, id_transaksi, pin):
        nomer_telepon = self.get_nomer_telepon(id_transaksi)
        # print(nomer_telepon)
        nominal =  self.database.get_nominal_by_transaksi(id_transaksi)
        # print(transaksi['nomor_telepon'])
        boolean_pin = self.database.check_pin(nomer_telepon, pin)
        if boolean_pin == True:
            # print(transaksi)
            boolean_saldo = self.database.check_saldo(nomer_telepon, nominal )
            # boolean_saldo = self.check_saldo(transaksi['no_telp'], transaksi['nominal'])
            if boolean_saldo == True:
                self.database.update_status_transaksi(id_transaksi)
                self.database.update_saldo(nomer_telepon, nominal)
                return True
            else :
                return False
        else:
            return False
        
    @rpc
    def get_status_transaksi(self, id_transaksi):
        boolean = self.database.get_status_transaksi(id_transaksi)
        return boolean
    
    @rpc
    def get_nomer_telepon(self, id_transaksi):
        no_telp = self.database.get_no_telp_by_transaksi(id_transaksi)
        return no_telp

    @rpc
    def get_timestamp(self, id_transaksi):
        timestamp = self.database.get_timestamp_by_transaksi(id_transaksi)
        return timestamp

    




    
