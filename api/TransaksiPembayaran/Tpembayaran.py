from nameko.rpc import rpc
import dependencies

class Transferservice:

    name = 'transaksi_pembayaran_service'

    database = dependencies.Database()

    # Get berdasarkan id_pesanan
    @rpc
    def get__byIDPesanan(self, IDPesanan):
        trans = self.database.get__byIDPesanan(IDPesanan)
        return {
            'code' : 200,
            'data' : trans
        }

    # Get berdasarkan id_transaksi    
    @rpc
    def get__byIDTransaksi(self, IDTransaksi):
        trans = self.database.get__byIDTransaksi(IDTransaksi)
        return {
            'code' : 200,
            'data' : trans
        }

    # Update berdasarkget__byIDTransaksiid_pesanan ( jenis_pembayaran, nama_penyedia, status)
    @rpc
    def update__byIDTransaksi(self, IDTransaksi, jenis_pembayaran, nama_penyedia, status):
        trans = self.database.update__byIDTransaksi(IDTransaksi, jenis_pembayaran, nama_penyedia, status)
        return {
            'code' : 200,
            'data' : trans
        }
        
    
    @rpc
    def create_pembayaran(self, id_pesanan, id_pesanan2, total_transaksi):
        success = self.database.create_pembayaran(id_pesanan, id_pesanan2, total_transaksi)
        if success:
            return {
                'code': 200,
                'data': success
            }
        else:
            return {
                'code': 500,
                'data': success
            }
            
    
    #update status berdasarkan id_pesanan
    @rpc
    def update_status_pembayaran(self, id_pesanan, status):
        success = self.database.update_status_pembayaran(id_pesanan, status)
        
        if not success:
            return {
                'code': 500,
                'data': False
            }
        else :
            return {
                'code': 200,
                'data': True
            }
    
    #update id_transaksi berdasarkan id_pesanan
    @rpc
    def update_idTransaksi(self, id_pesanan, id_transaksi):
        success = self.database.update_idTransaksi(id_pesanan, id_transaksi)
        
        if not success:
            return {
                'code': 500,
                'data': False
            }
        else :
            return {
                'code': 200,
                'data': True
            }
            
    
    #update id_transaksi, jenis_pembayaran, nama_penyedia, status berdasarkan id_pesanan
    @rpc
    def update_pembayaran(self, id_pesanan, id_transaksi, jenis_pembayaran, nama_penyedia):
        print("masuk update1")
        success = self.database.update_pembayaran(id_pesanan, id_transaksi, jenis_pembayaran, nama_penyedia)
        
        if not success:
            return {
                'code': 500,
                'data': False
            }
        else :
            return {
                'code': 200,
                'data': True
            }