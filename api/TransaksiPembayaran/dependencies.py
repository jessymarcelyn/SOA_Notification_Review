from nameko.extensions import DependencyProvider
import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling
import json
from datetime import datetime, timedelta
import pytz
from cryptography.fernet import Fernet
import hashlib
import base64

class DateTimeEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, datetime):
            return obj.isoformat()
        return json.JSONEncoder.default(self, obj)
    
class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection
   
    def get__byIDPesanan(self, IDPesanan):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM trans_pembayaran WHERE id_pesanan = {}" .format((IDPesanan))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_pembayaran' : row['id_pembayaran'],
                'id_pesanan' : row['id_pesanan'],
                'id_transaksi' : row['id_transaksi'],
                'timestamp' : row['timestamp'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp'], datetime) else row['timestamp'],
                'jenis_pembayaran' : row['jenis_pembayaran'],
                'nama_penyedia' : row['nama_penyedia'],
                'status' : row['status'],
            })
        cursor.close()
        if result:
            return result
        else:
            return None
        
    def get__byIDTransaksi(self, IDTransaksi):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM trans_pembayaran WHERE id_transaksi = {}" .format((IDTransaksi))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_pembayaran' : row['id_pembayaran'],
                'id_pesanan' : row['id_pesanan'],
                'id_transaksi' : row['id_transaksi'],
                'timestamp' : row['timestamp'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp'], datetime) else row['timestamp'],
                'jenis_pembayaran' : row['jenis_pembayaran'],
                'nama_penyedia' : row['nama_penyedia'],
                'status' : row['status'],
            })
        cursor.close()
        if result:
            return result
        else:
            return None
        
    def update__byIDTransaksi(self, IDTransaksi, timestamp, jenis_pembayaran, nama_penyedia):

        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE trans_pembayaran SET timestamp = %s, jenis_pembayaran = %s, nama_penyedia = %s, status = 'success' WHERE id_transaksi = %s"
        cursor.execute(sql, (timestamp, jenis_pembayaran, nama_penyedia, IDTransaksi))
        self.connection.commit()
        cursor.close() 
        get = self.get__byIDTransaksi(IDTransaksi)
        return  get     

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
