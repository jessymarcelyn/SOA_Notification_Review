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
    
    @rpc
    def change_payment_status(self, id_pembayaran, status):
        # input_payment = self.database.get_pembayaran_by_id_pembayaran(id_pembayaran)
        # if input_payment is None:
        #     return {
        #         'code': 404,
        #         "data": "Payment ID invalid"
        #     }
    
        room = self.database.change_payment_status(id_pembayaran, status)
        return {
            'code': 200,
            'data': room
        }
    
    @rpc
    def delete_pembayaran_by_id(self, id_pembayaran):
        input_payment = self.database.get_pembayaran_by_id_pembayaran(id_pembayaran)
        if input_payment is None:
            return {
                'code': 404,
                "data": "ID Pembayaran invalid"
            }
        
        pembayaran = self.database.delete_pembayaran_by_id(id_pembayaran)
        return {
            'code': 200,
            'data': pembayaran
        }
