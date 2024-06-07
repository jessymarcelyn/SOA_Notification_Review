from nameko.rpc import RpcProxy
from nameko.web.handlers import http
import json
import datetime 
from werkzeug.wrappers import Response

class GatewayService:
    name = 'gateway'

    notif_rpc = RpcProxy('transfer_service')

    #GET notif berdasarkan id_notif

    
