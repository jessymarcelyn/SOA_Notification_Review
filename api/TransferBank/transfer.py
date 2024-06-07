from nameko.rpc import rpc
import dependencies

class Notifservice:

    name = 'transfer_service'

    database = dependencies.Database()

