from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling
import json
from datetime import datetime
import hashlib


    
class DatabaseWrapper:
    connection = None

    def __init__(self, connection):
        self.connection = connection
        
    
    # aman
    def get_no_telp(self, no_telp):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT COUNT(*) as count from gopay where nomor_telepon = '{}'".format(no_telp)
        cursor.execute(sql)
        result = cursor.fetchone()  # Use fetchone to get a single row

        if result['count'] == 1:
            return True # Nomor telepon tersedia di database
        else:
            return False, "Nomer tidak terdaftar"  # Nomor telepon tidak tersedia di database
       
    

    def check_pin(self, no_telp, pin):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT pin from gopay where nomor_telepon = {}".format((no_telp)) 
        cursor.execute(sql)
        result = cursor.fetchone()  # Use fetchone to get a single row
        # print(result['pin'])
        # hashed_pin = hashlib.sha256(pin.encode()).hexdigest()
      
        if result['pin'] == pin:
            return True
        else:
            return False, "Pin tidak valid"
        
    #aman 
    def check_saldo(self, no_telp, nominal):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT saldo from gopay where nomor_telepon = {} ".format((no_telp))
        
        cursor.execute(sql)
        result = cursor.fetchone()  # Use fetchone to get a single row

        print(result['saldo'])
        print(nominal)
        if result['saldo'] >= nominal:
            return True
        else:
            return False, "Saldo tidak cukup"
        
    #aman 
    def update_saldo(self, no_telp, nominal):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE gopay SET saldo = saldo - %s WHERE nomor_telepon = %s"
        params = (nominal, no_telp)
        cursor.execute(sql, params)
        self.connection.commit()  # Make sure to commit the transaction
        return True


    # aman
    def insert_transaksi(self, no_telp, nominal):
        cursor = self.connection.cursor(dictionary=True)
        sql = "INSERT INTO transaksigopay (nomor_telepon, nominal) VALUES (%s, %s)"
        params = (no_telp, nominal)
        
        cursor.execute(sql, params)
        self.connection.commit()  # Make sure to commit the transaction
        transaction_id = cursor.lastrowid
        
        return transaction_id

    
    # def get_transaksi(self, no_telp):
    #     cursor = self.connection.cursor(dictionary=True)
    #     result = []
    #     sql = "SELECT * from transaksi where no_telp = ".format((no_telp))
    #     cursor.execute(sql)
    #     for row in cursor.fetchall():
    #         result.append({
    #             'id_transaksi': row['id_transaksi'],
    #             'no_telp': row['no_telp'],
    #             'nominal': row['nominal'],
    #             'timestamp': row['timestamp'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp'], datetime) else row['timestamp'],
    #         })
    #     cursor.close()
    #     return result



    # blm kepakek
    def get_transaksi(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM transaksigopay WHERE id = %s"
        cursor.execute(sql, (id_transaksi,))
        result = []
        for row in cursor.fetchall():
            result.append({
                'id': row['id'],
                'nomor_telepon': row['nomor_telepon'],
                'nominal': row['nominal'],
                'timestamp': row['timestamp'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp'], datetime) else row['timestamp'],
            })
        cursor.close()
        return result

    
    # aman
    def get_no_telp_by_transaksi(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT nomor_telepon from transaksigopay where id = {}".format((id_transaksi))
        cursor.execute(sql)
        result = cursor.fetchone()  # fetchone() returns a dictionary

        # if result:
        return result['nomor_telepon']  # Return only the phone number
        # else:
        #     return False  # Return False if the transaction ID is not found



    # aman
    def get_nominal_by_transaksi(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT nominal from transaksigopay where id = {}".format((id_transaksi))
        cursor.execute(sql)
        result = cursor.fetchone()  
        return result['nominal']  # Return only the phone number
    

    # aman
    def update_status_transaksi(self, id_transaksi):
        try:
            cursor = self.connection.cursor(dictionary=True)
            print("idtra", id_transaksi)
            sql = "UPDATE transaksigopay SET status = 1 WHERE id = {}".format(id_transaksi)
            # params = (id_transaksi,)
            cursor.execute(sql)
            self.connection.commit()
            print("Status updated successfully")
            return True
        
        except Exception as e:
            print("Error updating status:", e)
            return False


    
    def get_status_transaksi(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT status FROM transaksigopay WHERE id = %s"
        cursor.execute(sql, (id_transaksi,))
        result = cursor.fetchone()
        if result and result['status'] == 1:
            return True
        else:
            return False
        
    def get_timestamp(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT timestamp FROM transaksigopay WHERE id = %s"
        cursor.execute(sql, (id_transaksi,))
        result = cursor.fetchone()
        return result['timestamp']  # Return only timestamp



    
    
    
class Database(DependencyProvider):
    def __init__(self):
        self.connection_pool = None
        try:
            self.connection_pool = mysql.connector.pooling.MySQLConnectionPool(
                pool_name="database_pool",
                pool_size=10,
                pool_reset_session=True,
                host='localhost',
                database='soa',
                user='root',
                password=''
            )
            print("Connection pool created successfully")
        except Error as e:
            print("Error while connecting to MySQL using Connection pool:", e)
            self.connection_pool = None

    def get_dependency(self, worker_ctx):
        if self.connection_pool:
            try:
                return DatabaseWrapper(self.connection_pool.get_connection())
            except Error as e:
                print("Error getting connection from pool:", e)
                raise RuntimeError("Failed to get connection from pool")
        else:
            raise RuntimeError("No connection pool available")
     

    
    
    
    
