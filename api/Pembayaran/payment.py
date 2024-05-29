from nameko.rpc import rpc
import dependencies

class PaymentService:

    name = 'payment_service'

    database = dependencies.Database()

    @rpc
    def hello(self):
        return "Hello,!"

    @rpc
    def get_pembayaran_by_id_pesanan(self, id_pesanan):
        pembayaran = self.database.get_pembayaran_by_id_pesanan(id_pesanan)
        return pembayaran
    
    @rpc
    def get_pembayaran_by_id_pembayaran(self, id_pembayaran):
        pembayaran = self.database.get_pembayaran_by_id_pembayaran(id_pembayaran)
        return pembayaran
    
    @rpc
    def get_all_pembayaran_by_id_user(self,  id_user):
        pembayaran = self.database.get_all_pembayaran_by_id_user(id_user)
        return pembayaran
    
    @rpc
    def get_all_pembayaran(self):
        pembayaran = self.database.get_all_pembayaran()
        return pembayaran
        
    @rpc
    def get_all_pembayaran_by_jenis_pembayaran(self, jenis_pembayaran):
        pembayaran = self.database.get_all_pembayaran_by_jenis_pembayaran(jenis_pembayaran)
        return pembayaran
    
    @rpc
    def insert_pembayaran(self, id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp):
        pembayaran = self.database.insert_pembayaran(id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp)
        return pembayaran
