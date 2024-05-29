from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling

class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection

    def get_all_notif(self):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi"
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'],
                'timestamp_announce': row['timestamp_announce'],
                'status': row['status'],
                'link': row['link'],
                'foto': row['foto'],
            })
        cursor.close()
        return result
    
    def get_notif_TimeAnnounce(self, timeAnnounce):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE timestamp_announce = %s"
        cursor.execute(sql, (timeAnnounce,))
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                'timestamp_masuk': row['timestamp_masuk'],
                'timestamp_announce': row['timestamp_announce'],
                'status': row['status'],
                'link': row['link'],
                'foto': row['foto'],
            })
        cursor.close()
        return result
    
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
                # 'timestamp_masuk': row['timestamp_masuk'],
                # 'timestamp_announce': row['timestamp_announce'],
                'status': row['status'],
                'link': row['link'],
                'foto': row['foto'],
            })
        cursor.close()
        return result
    
    def get_notif_IDUser(self, idUser):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE id_user = {}" .format((idUser))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                # 'timestamp_masuk': row['timestamp_masuk'],
                # 'timestamp_announce': row['timestamp_announce'],
                'status': row['status'],
                'link': row['link'],
                'foto': row['foto'],
            })
        cursor.close()
        return result
    
    def get_notif_status(self, status):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM notifikasi WHERE status = {}" .format((status))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id_notif': row['id_notif'],
                'id_user': row['id_user'],
                'tipe_notif': row['tipe_notif'],
                'judul': row['judul'],
                'deskripsi': row['deskripsi'],
                # 'timestamp_masuk': row['timestamp_masuk'],
                # 'timestamp_announce': row['timestamp_announce'],
                'status': row['status'],
                'link': row['link'],
                'foto': row['foto'],
            })
        cursor.close()
        return result
    
    def delete_notif(self, idNotif):
        cursor = self.connection.cursor(dictionary=True)
        sql = "DELETE from notifikasi WHERE id_notif = {}".format((idNotif))
        cursor.execute(sql)
        self.connection.commit()
        cursor.close()
        return f"{idNotif} is deleted."
    

    def __del__(self):
       self.connection.close()

    # def update_notif_ID(self, idNotif):
    #     cursor = self.connection.cursor(dictionary=True)
    #     sql = "UPDATE notifikasi SET timestamp_announce = {}  WHERE id_notif = {}".format(())
    #     cursor.execute(sql)
    #     self.connection.commit()
    #     cursor.close()
    #     return f"{idNotif} room status is changed."



class Database(DependencyProvider):

    connection_pool = None

    def __init__(self):
        try:
            self.connection_pool = mysql.connector.pooling.MySQLConnectionPool(
                pool_name="database_pool",
                pool_size=10,
                pool_reset_session=True,
                host='localhost',
                database='SOA',
                user='root',
                password=''
            )
        except Error as e :
            print ("Error while connecting to MySQL using Connection pool ", e)

    def get_dependency(self, worker_ctx):
        return DatabaseWrapper(self.connection_pool.get_connection())
