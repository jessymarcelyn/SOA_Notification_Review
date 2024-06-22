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
        return json.JSONEncoder.default(self, obj)
    
class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection

    #GET all notif
    def get_all_notif(self):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi"
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return result
    
    # def get_notif_TimeAnnounce(self, timeAnnounce):
    #     cursor = self.connection.cursor(dictionary=True)
    #     result = []
    #     sql = "SELECT * FROM notifikasi WHERE timestamp_announce = %s"
    #     cursor.execute(sql, (timeAnnounce,))
    #     for row in cursor.fetchall():
    #         result.append({
    #             'id_notif': row['id_notif'],
    #             'id_user': row['id_user'],
    #             'tipe_notif': row['tipe_notif'],
    #             'judul': row['judul'],
    #             'deskripsi': row['deskripsi'],
    #             'timestamp_masuk': row['timestamp_masuk'],
    #             'timestamp_announce': row['timestamp_announce'],
    #             'status': row['status'],
    #             'link': row['link'],
    #             'foto': row['foto'],
    #         })
    #     cursor.close()
    #     return result
    
    #GET notif berdasarkan id_notif
    def get_notif_ID(self, idNotif):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE id_notif = {}" .format((idNotif))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        # return result
        if result:
            return result[0]  # Asumsikan hanya ada satu notifikasi dengan ID tertentu
        else:
            return None
    
    #GET notif berdasarkan id_user
    def get_notif_IDUser(self, idUser):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE id_user = {}" .format((idUser))
        cursor.execute(sql)
        # if cursor.fetchall():
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        if result:
            return result  # Asumsikan hanya ada satu notifikasi dengan ID tertentu
        else:
            return None
        # return result

    #GET notif berdasarkan id_user
    def get_notif_IDUser_notifType(self, idUser, notifType):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE id_user = %s AND tipe_notif = %s"
        cursor.execute(sql, (idUser, notifType))
        # cursor.execute(sql)
        # if cursor.fetchall():
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        if result:
            return result  # Asumsikan hanya ada satu notifikasi dengan ID tertentu
            print(result)
        else:
            return None
        # return result

    #GET notif berdasarkan id_user
    def get_notif_IDPesanan(self, idPesanan):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE id_pesanan = {}" .format((idPesanan))
        cursor.execute(sql)
        # if cursor.fetchall():
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        if result:
            return result[0]  # Asumsikan hanya ada satu notifikasi dengan ID tertentu
        else:
            return None
        # return result
    
    #GET notif berdasarkan status 0/1
    def get_notif_status(self, status):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE status = {}" .format((status))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],                
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return result
    
    #DELETE notif berdasarkan id_notif
    def delete_notif(self, idNotif):
        cursor = self.connection.cursor(dictionary=True)
        sql = "DELETE from notifikasi WHERE id_notif = {}".format((idNotif))
        cursor.execute(sql)
        self.connection.commit()
        cursor.close()
        return f"{idNotif} is deleted."
    
    #GET notif berdasarkan tipe_notif
    def get_notif_type(self, tipe_notif):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE tipe_notif = %s"
        cursor.execute(sql, (tipe_notif,))
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return (result)
    
    #GET notif berdasarkan judul
    def get_notif_judul(self, judul):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE judul = %s"
        cursor.execute(sql, (judul,))
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return (result)
    
    #GET notif berdasarkan timestamp announce
    def get_notif_timestampA(self, timestamp):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE timestamp_announce = %s" 
        cursor.execute(sql, (timestamp,))
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return (result)
    
    #GET notif berdasarkan timestamp masuk
    def get_notif_timestampM(self, timestamp):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE timestamp_masuk = %s" 
        cursor.execute(sql, (timestamp,))
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'id_pesanan': row['id_pesanan'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_masuk'], datetime) else row['timestamp_masuk'],
                'status': row['status'],
                'link': row['link'],
            })
        cursor.close()
        return (result)
    
    # Add notification
    def add_notif(self, id_user, id_pesanan, tipe_notif, judul, deskripsi, timestamp_masuk, status, link ):
        try:
            cursor = self.connection.cursor(dictionary=True)
            sql = """
            INSERT INTO notifikasi (
                id_user, id_pesanan, tipe_notif,  judul, deskripsi, timestamp_masuk, 
                status, link
            ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
            """
            cursor.execute(sql, (id_user, id_pesanan, tipe_notif, judul, deskripsi, timestamp_masuk, status, link));
            self.connection.commit()
            cursor.close()
            return True
        except Exception as e:
            return {"error": str(e)}
        
    # Update notification
    def update_notif_status(self, id_notif):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE notifikasi SET status = 1 WHERE id_notif = %s"
        cursor.execute(sql, (id_notif,))  # Notice the comma to create a tuple
        self.connection.commit()
        cursor.close()
        return True
    
    def update_notif_link(self, id_notif):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE notifikasi SET link = null WHERE id_notif = %s"
        cursor.execute(sql, (id_notif, ))
        self.connection.commit()
        cursor.close()
        return True

    def update_notif_link_pesanan(self, id_pesanan, judul):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE notifikasi SET link = null WHERE id_pesanan = %s && judul = %s" 
        cursor.execute(sql, (id_pesanan, judul, ))
        self.connection.commit()
        cursor.close()
        return True
    

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