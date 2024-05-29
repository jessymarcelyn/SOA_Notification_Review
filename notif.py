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