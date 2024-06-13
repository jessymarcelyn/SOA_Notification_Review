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