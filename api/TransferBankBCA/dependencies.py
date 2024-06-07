from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling
import json
from datetime import datetime, timedelta
import pytz

class DateTimeEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, datetime):
            return obj.isoformat()
        return json.JSONEncoder.default(self, obj)
    
class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection

    #GET status berdasarkan id_transaksi
    def get_status_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT status FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'status' : row['status']
            })
        cursor.close()
        # return result
        if result:
            return result # Asumsikan hanya ada satu notifikasi dengan ID tertentu
        else:
            return None
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    def get_timestamp_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        # result = []
        sql = "SELECT timestamp_trans FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        # for row in cursor.fetchall():
        #     result.append({
        #         'status' : row['status']
        #     })
        row = cursor.fetchone()
        cursor.close()

        if row:
            timestamp_db = row['timestamp_trans']
            local_timezone = pytz.timezone("Asia/Jakarta")
            current_time = datetime.now(local_timezone)
            timestamp_local = local_timezone.localize(timestamp_db)
            if current_time - timestamp_local > timedelta(minutes=2):
                return {'status': 'Payment Failed'}
        else:
            return {'status': 'Payment Success'}

class Database(DependencyProvider):

    connection_pool = None

    def __init__(self):
        try:
            #database pool itu buka banyak koneksi.
            self.connection_pool = mysql.connector.pooling.MySQLConnectionPool(
                pool_name="database_pool",
                pool_size=10,
                pool_reset_session=True,
                host='localhost',
                database='soa',
                user='root',
                password=''
            )
        except Error as e :
            print ("Error while connecting to MySQL using Connection pool ", e)

    def get_dependency(self, worker_ctx):
        return DatabaseWrapper(self.connection_pool.get_connection())