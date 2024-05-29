from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 

class GatewayService:
    name = 'gateway'

    notif_rpc = RpcProxy('notif_service')

 #GET notif berdasarkan timestamp_announce
    def get_notif_TimeAnnounce(self, request,timestamp):
        # timestamp_str = timestamp.strftime('%Y-%m-%d %H:%M:%S')
        timestamp_dt = datetime.datetime.strptime(timestamp, '%Y-%m-%d %H:%M:%S')
        # Format objek datetime menjadi string dengan metode strftime
        timestamp_str = timestamp_dt.strftime('%Y-%m-%d %H:%M:%S')
        # Panggil metode untuk mendapatkan notifikasi
        notifs = self.notif_rpc.get_notif_TimeAnnounce(timestamp_str)
        return json.dumps(notifs)

    #GET notif berdasarkan id_notif
    @http('GET', '/notif/<int:idNotif>')
    def get_notif_ID(self, request, idNotif):
        notif = self.notif_rpc.get_notif_ID(idNotif)
        return json.dumps(notif)

    #GET semua notif
    @http('GET', '/notif')
    def get_rooms(self, request):
        notifs = self.notif_rpc.get_all_notif()
        return json.dumps(notifs)

    #GET notif berdasarkan id user
    @http('GET', '/notif/user/<int:idUser>')
    def get_notif_IDUser(self, request, idUser):
        notifs = self.notif_rpc.get_notif_IDUser(idUser)
        return json.dumps(notifs)

    #PUT berdasarkan id_notif 
    # @http('PUT', '/notif/<int:idNotif>')
    # def update_notif_ID(self, request, idNotif):
    #     # data = json.loads(request.get_data(as_text=True))
    #     notif = self.notif_rpc.update_notif_ID(idNotif)
    #     return notif['code'],json.dumps(notif['data'])
    
    #Delete berdasarkan id_notif
    @http('DELETE', '/notif/<int:idNotif>')
    def delete_notif(self, request, idNotif):
        notif = self.notif_rpc.delete_notif(idNotif)
        return notif['code'],json.dumps(notif['data'])

    #GET notif berdasarkan status
    @http('GET', '/notif/status/<int:status>')
    def get_notif_status(self, request, status):
        notifs = self.notif_rpc.get_notif_status(status)
        return json.dumps(notifs)
    
    #GET notif berdasarkan tipe 
    @http('GET', '/notif/tipe/<string:tipe_notif>')
    def get_notif_type(self, request, tipe_notif):
        notifs = self.notif_rpc.get_notif_type(tipe_notif)
        return json.dumps(notifs)
    
    #GET notif berdasarkan judul
    @http('GET', '/notif/judul/<string:judul>')
    def get_notif_judul(self, request, judul):
        notifs = self.notif_rpc.get_notif_judul(judul)
        return json.dumps(notifs)
    
    # GET notif berdasarkan timestamp
    @http('GET', '/notif/timestamp/<string:timestamp>')
    def get_notif_timestamp(self, request, timestamp):
        notifs = self.notif_rpc.get_notif_timestamp(str(timestamp))  # Convert datetime to string
        return json.dumps(notifs)
    
    # create a new notification
    @http('POST', '/notif')
    def add_notif(self, request):
        try:
            data = json.loads(request.get_data(as_text=True))
            id_user = data.get('id_user')
            tipe_notif = data.get('tipe_notif')
            jenis = data.get('jenis')
            judul = data.get('judul')
            deskripsi = data.get('deskripsi')
            timestamp_masuk = data.get('timestamp_masuk')
            timestamp_announce = data.get('timestamp_announce')
            status = data.get('status')
            link = data.get('link')  # Use get() method to get optional fields
            foto = data.get('foto')  # Use get() method to get optional fields
            
            # Call add_notif method with optional fields
            notif = self.notif_rpc.add_notif(
                id_user, tipe_notif, jenis, judul, deskripsi, timestamp_masuk, 
                timestamp_announce, status, link, foto
            )
            return 200, json.dumps(notif)
        except Exception as e:
            return 500, json.dumps({"error": str(e)})
    #GET semua notif
    
