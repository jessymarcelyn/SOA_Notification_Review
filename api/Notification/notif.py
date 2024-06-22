from nameko.rpc import rpc
import dependencies

class Notifservice:

    name = 'notif_service'

    database = dependencies.Database()

    @rpc
    def get_all_notif(self):
        notifs = self.database.get_all_notif()
        return {
            'code' : 200,
            'data' : notifs
        }
    
    @rpc
    def get_notif_ID(self, idNotif):
        notif = self.database.get_notif_ID(idNotif)
        # if notif:
        #     return {
        #         'code' : 200,
        #         'data' : notif
        #     }
        # else :
        #     return {
        #         'code' : 404,
        #         'data' : 'No Notification found with this ID'
        #     }
        return notif
    
    @rpc
    def get_notif_IDUser(self, idUser):
        notifs = self.database.get_notif_IDUser(idUser)
        # if notifs:
        #     return {
        #         'code' : 200,
        #         'data' : notifs
        #     }
        # else :
        #     return {
        #         'code' : 404,
        #         'data' : 'No Notification found with this ID'
        #     }
        return notifs
    
    @rpc
    def get_notif_IDUser_notifType(self, idUser, notifType):
        notifs = self.database.get_notif_IDUser_notifType(idUser, notifType)
        # if notifs:
        #     return {
        #         'code' : 200,
        #         'data' : notifs
        #     }
        # else :
        #     return {
        #         'code' : 404,
        #         'data' : 'No Notification found with this ID'
        #     }
        return notifs

    # @rpc
    # def get_notif_IDUser(self, idPesanan):
    #     notifs = self.database.get_notif_IDPesanan(idPesanan)
    #     # if notifs:
    #     #     return {
    #     #         'code' : 200,
    #     #         'data' : notifs
    #     #     }
    #     # else :
    #     #     return {
    #     #         'code' : 404,
    #     #         'data' : 'No Notification found with this ID'
    #     #     }
    #     return notifs

    @rpc
    def get_notif_status(self, status):
        notifs = self.database.get_notif_status(status)
        if notifs:
            return {
                'code' : 200,
                'data' : notifs
            }
        else:
            return {
                'code' : 404,
                'data' : 'No Notification found with this ID'
            }

    
    # @rpc
    # def update_notif_ID(self, idNotif):
    #     exist = self.database.get_notif_ID(idNotif)
    #     if not exist: 
    #         return{
    #             'code': 404,
    #             'data': 'Notifikasi tidak dapat ditemukan.'
    #         }
        
    #     notif = self.database.update_notif_ID(idNotif)
    #     return {
    #         'code':200,
    #         'data': notif
    #     }

    @rpc
    def delete_notif(self, idNotif):
        exist = self.database.get_notif_ID(idNotif)
        if not exist: 
            return{
                'code': 404,
                'data': 'Notifikasi tidak dapat ditemukan.'
            }
        notif = self.database.delete_notif(idNotif)
        return {
            'code': 200,
            'data': notif
            }
    
    @rpc
    def get_notif_type(self, tipe_notif):
        notifs = self.database.get_notif_type(tipe_notif)
        if notifs:
            return {
                'code' : 200,
                'data' : notifs
            }
        else :
            return {
                'code' : 404,
                'data' : 'No Notification found with this ID'
            }
    
    @rpc
    def get_notif_judul(self, judul):
        notifs = self.database.get_notif_judul(judul)
        if not notifs: 
            return {
                'code': 404,
                'data': 'No notifications found for the given judul'
            }
        else:
            return {
                'code': 200,
                'data': notifs
            }
    
    @rpc
    def get_notif_timestampA(self, timestamp_announce):
        notifs = self.database.get_notif_timestampA(timestamp_announce)
        if notifs:
            return {
                'code' : 200,
                'data' : notifs
            }
        else :
            return {
                'code' : 404,
                'data' : 'No Notification found with this ID'
            }
    
    @rpc
    def get_notif_timestampM(self, timestamp_masuk):
        notifs = self.database.get_notif_timestampM(timestamp_masuk)
        if notifs:
            return {
                'code' : 200,
                'data' : notifs
            }
        else :
            return {
                'code' : 404,
                'data' : 'No Notification found with this ID'
            }

    # Add notification
    @rpc
    def add_notif(self, id_user, id_pesanan, tipe_notif,  judul, deskripsi, timestamp_masuk, status, link):
        notifs = self.database.add_notif(id_user, id_pesanan, tipe_notif,  judul, deskripsi, timestamp_masuk, status, link)
        return {
            'code': 200,
            'data': notifs
        }

    # Update notification
    @rpc
    def update_notif_status(self, id_notif):
        notifs = self.database.update_notif_status(id_notif)
        return {
            'code': 200,
            'data': notifs
        }
    
    @rpc
    def update_notif_link(self, id_notif):
        notifs = self.database.update_notif_link(id_notif)
        return {
            'code': 200,
            'data': notifs
        }
    
    @rpc
    def update_notif_link_pesanan(self, id_pesanan, judul):
        notifs = self.database.update_notif_link_pesanan(id_pesanan, judul)
        return {
            'code': 200,
            'data': notifs
        }