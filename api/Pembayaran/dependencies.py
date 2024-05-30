from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling
import json
from datetime import datetime

class DateTimeEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, datetime):
            return obj.isoformat()
        return super().default(obj) 
    
class DatabaseWrapper:
    connection = None

    def __init__(self, connection):
        self.connection = connection
        
    
    def get_pembayaran_by_id_pesanan(self, id_pesanan):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where id_pesanan ={}".format((id_pesanan))
        cursor.execute(sql)
        result = cursor.fetchone()
        cursor.close()
        return json.dumps(result, cls=DateTimeEncoder)
    
    def get_pembayaran_by_id_pembayaran(self, id_pembayaran):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where id_pembayaran ={}".format((id_pembayaran))
        cursor.execute(sql)
        result = cursor.fetchone()
        cursor.close()
        return json.dumps(result, cls=DateTimeEncoder)
    
    def get_all_pembayaran_by_id_user(self, id_user):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where id_user ={}".format((id_user))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append(row)
        cursor.close()
        return json.dumps(result, cls=DateTimeEncoder)
    
    def get_all_pembayaran(self):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran"
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append(row)
        cursor.close()
        return json.dumps(result, cls=DateTimeEncoder)
    
    def get_all_pembayaran_by_jenis_pembayaran(self, jenis_pembayaran):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM pembayaran WHERE jenis_pembayaran = %s"
        cursor.execute(sql, (jenis_pembayaran,))
        for row in cursor.fetchall():
            result.append(row)
        cursor.close()
        return json.dumps(result, cls=DateTimeEncoder)
    
    def insert_pembayaran(self, id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp):
        cursor = self.connection.cursor(dictionary=True)
        sql = "INSERT INTO pembayaran (id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar,  nama_penyedia, nomer_kartu, nomer_rekening, nomer_telp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
        val = (id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp)
        cursor.execute(sql, val)
        self.connection.commit()
        cursor.close()
        return True

    def change_payment_status(self, id_pembayaran, status):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE pembayaran SET status = %s WHERE id_pembayaran = %s"
        cursor.execute(sql, (status, id_pembayaran))
        self.connection.commit()
        result = cursor.fetchone()
        cursor.close()
        return result
    
    def delete_pembayaran_by_id(self, id_pembayaran):
        cursor = self.connection.cursor(dictionary=True)
        sql = "DELETE from pembayaran WHERE id_pembayaran = {}".format((id_pembayaran))
        cursor.execute(sql)
        self.connection.commit()
        cursor.close()
        return f"{id_pembayaran} is deleted."

    
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
     

    
    
    
    
