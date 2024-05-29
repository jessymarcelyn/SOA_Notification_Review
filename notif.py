from nameko.rpc import rpc

import dependencies

class RoomService:

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
    def get_notif_TimeAnnounce(self, timestamp_announce):
        notifs = self.database.get_notif_TimeAnnounce(timestamp_announce)
        return {
            'code' : 200,
            'data' : notifs
        }
    
    @rpc
    def get_notif_ID(self, idNotif):
        notif = self.database.get_notif_ID(idNotif)
        return {
            'code' : 200,
            'data' : notif
        }
    
    @rpc
    def get_notif_IDUser(self, idUser):
        notifs = self.database.get_notif_IDUser(idUser)
        return {
            'code' : 200,
            'data' : notifs
        }
    
    @rpc
    def get_notif_status(self, status):
        notifs = self.database.get_notif_status(status)
        return {
            'code' : 200,
            'data' : notifs
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

