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
        
    def update__byIDTransaksi(self, IDTransaksi, jenis_pembayaran, nama_penyedia, status):

        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE trans_pembayaran SET timestamp = NOW(), jenis_pembayaran = %s, nama_penyedia = %s, status = %s WHERE id_transaksi = %s"
        cursor.execute(sql, (jenis_pembayaran, nama_penyedia, status, IDTransaksi))
        self.connection.commit()
        cursor.close() 
        get = self.get__byIDTransaksi(IDTransaksi)
        # return {"Status updated to success. Payment is already paid."}
        return get
    
    def create_pembayaran(self, id_pesanan, id_pesanan2, total_transaksi):
        print("masuk")
        cursor = self.connection.cursor(dictionary=True)
        status = "initial"
        timestamp = datetime.now()
        sql = ("INSERT INTO trans_pembayaran (id_pesanan, id_pesanan2, total_transaksi, status, timestamp ) "
               "VALUES (%s, %s, %s, %s, %s)")

        val = (id_pesanan, id_pesanan2, total_transaksi, status, timestamp)
        try:
            cursor.execute(sql, val)
            self.connection.commit()
            cursor.close()
            return True
        except mysql.connector.Error as err:
            print(f"Error: {err}")
            cursor.close()
            return False
    
    def update_status_pembayaran(self, id_pesanan, status):
        cursor = self.connection.cursor(dictionary=True)

        try:
            sql = "UPDATE trans_pembayaran SET status = %s WHERE id_pesanan = %s"
            val = (status, id_pesanan)

            cursor.execute(sql, val)
            self.connection.commit()
            
            return True

        except mysql.connector.Error as err:
            print(f"Error: {err}")
            return False

        finally:
            cursor.close()
    
    def update_idTransaksi(self, id_pesanan, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)

        try:
            sql = "UPDATE trans_pembayaran SET id_transaksi = %s WHERE id_pesanan = %s"
            val = (id_transaksi, id_pesanan)

            cursor.execute(sql, val)
            self.connection.commit()
            
            return True

        except mysql.connector.Error as err:
            print(f"Error: {err}")
            return False

        finally:
            cursor.close()
    
    def update_pembayaran(self, id_pesanan, id_transaksi, jenis_pembayaran, nama_penyedia):
        print("masuk update2")
        cursor = self.connection.cursor(dictionary=True)

        try:
            status = "ongoing"
            timestamp = datetime.now()
            sql = "UPDATE trans_pembayaran SET id_transaksi = %s, jenis_pembayaran = %s,  nama_penyedia = %s, status= %s, timestamp = %s WHERE id_pesanan = %s"
            val = (id_transaksi, jenis_pembayaran, nama_penyedia, status, timestamp, id_pesanan)
            print("id_transaksi ", id_transaksi)
            print("jenis_pembayaran ", jenis_pembayaran)
            print("nama_penyedia ", nama_penyedia)
            print("status ", status)
            print("timestamp ", timestamp)
            print("id_pesanan ", id_pesanan)

            cursor.execute(sql, val)
            self.connection.commit()
            
            return True

        except mysql.connector.Error as err:
            print(f"Error: {err}")
            return False

        finally:
            cursor.close()
        
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
