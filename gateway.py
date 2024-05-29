import json

from nameko.rpc import RpcProxy
from nameko.web.handlers import http


class GatewayService:
    name = 'gateway'

    notif_rpc = RpcProxy('notif_service')

    #GET notif berdasarkan timestamp_announce

    #GET notif berdasarkan id_notif

    #GET semua notif
    @http('GET', '/notif')
    def get_rooms(self, request):
        rooms = self.notif_rpc.get_all_notif()
        return json.dumps(notifs)

    #Update berdasarkan id_notif

    #PUT berdasarkan id_notif 

    #Delete berdasarkan id_notif

