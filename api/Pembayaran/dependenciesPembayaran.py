from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling

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
        return result
    
    def get_pembayaran_by_id_pembayaran(self, id_pembayaran):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where id_pembayaran ={}".format((id_pembayaran))
        cursor.execute(sql)
        result = cursor.fetchone()
        cursor.close()
        return result
    
    def get_all_pembayaran_by_id_user(self, id_user):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where id_user ={}".format((id_user))
        cursor.execute(sql)
        result = cursor.fetchall()
        cursor.close()
        return result
    
    def get_all_pembayaran(self):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran"
        cursor.execute(sql)
        result = cursor.fetchall()
        cursor.close()
        return result
    
    def get_all_pembayaran_by_jenis_pembayaran(self, jenis_pembayaran):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * from pembayaran where jenis_pembayaran ={}".format((jenis_pembayaran))
        cursor.execute(sql)
        result = cursor.fetchall()
        cursor.close()
        return result
    
    def create_pembayaran(self, id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp):
        cursor = self.connection.cursor(dictionary=True)
        sql = "INSERT INTO pembayaran (id_pesanan, id_user, sub_total, pajak, total_bayar, jenis_pembayaran, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp) VALUES (%s, %s, %s, %s, %s)"
        val = (id_pesanan, id_user, jenis_pembayaran, sub_total, pajak, total_bayar, nama_penyedia, nomer_kartu, nomor_rekening, nomor_telp)
        cursor.execute(sql, val)
        self.connection.commit()
        cursor.close()
        # return cursor.lastrowid
    
    
class Database(DependencyProvider):
    connection_pool = None
    
    def __init__(self):
        try:
            self.connection_pool = mysql.connector.pooling.MySQLConnectionPool(
            pool_name="database_pool",
            pool_size=5,
            pool_reset_session=True,
            host='localhost',
            database='project2',
            user='root',
            password=''
            )
        except Error as e :
            print ("Error while connecting to MySQL using Connection pool ", e)
            
        def get_dependency(self, worker_ctx):
         return DatabaseWrapper(self.connection_pool.get_connection())

    
    
    
    
