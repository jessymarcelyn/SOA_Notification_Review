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
    
    def hash_value(self, value):
        return hashlib.sha256(value.encode()).hexdigest()

    def get_byNoTelp(self, noTelp):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM bankbca WHERE no_telp = {}" .format((noTelp))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'no_telp' : row['no_telp'],
            })
        cursor.close()
        if result:
            return True
        else:
            return None
        
    def createBankAcc(self, nama, no_rek, pin, saldo, no_telp):
        hash_pin = self.hash_value(pin)
        try:
            cursor = self.connection.cursor(dictionary=True)
            sql = " INSERT INTO bankbca (nama, no_rek, pin, no_telp, saldo) VALUES (%s, %s, %s, %s, %s)"
            cursor.execute(sql, (nama, no_rek, hash_pin, no_telp, saldo))
            self.connection.commit()
            cursor.close()
            return True
        except Exception as e:
            return {"error": str(e)}
        
    def CheckPin(self, no, pin):
        hash_pin = self.hash_value(pin)
        print("hashed pin: " + hash_pin)
        
        cursor = self.connection.cursor(dictionary=True)
        
        try:
            sql = "SELECT pin FROM bankbca WHERE no_telp = %s"
            cursor.execute(sql, (no,))
            row = cursor.fetchone()
            
            if row:
                stored_pin = row['pin']
            else:
                stored_pin = None

            cursor.fetchall()
        
        finally:
            cursor.close()

        if stored_pin and stored_pin == hash_pin:
            return True
        else:
            return False
    
    @staticmethod
    def generate_key():
        return Fernet.generate_key()

    def encrypt_value(self, value):
        return self.cipher_suite.encrypt(value.encode()).decode()

    def decrypt_value(self, encrypted_value):
        return self.cipher_suite.decrypt(encrypted_value.encode()).decode()

    def hash_value(self, value):
        return hashlib.sha256(value.encode()).hexdigest()
    
    #GET berdasarkan id_transaksi
    def get_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id' : row['id'],
                'timestamp_trans' : row['timestamp_trans'].strftime('%Y-%m-%d %H:%M:%S') if isinstance(row['timestamp_trans'], datetime) else row['timestamp_trans'],
                'no_telp' : row['no_telp'],
                'nominal' : row['nominal'],
                'status' : row['status'],
                'va' : row['va']
            })
        cursor.close()
        if result:
            return result
        else:
            return None
        
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
        
    #SET FAILED STATUS karena lebih dari 2 menit 
    def set_failed (self, idTrans):
        status = 'failed'
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE transbca SET status = %s, timestamp_trans = NOW() WHERE id = %s" 
        cursor.execute(sql, (status, idTrans))
        self.connection.commit()
        cursor.close()   
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    def get_timestamp_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT timestamp_trans, status FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        row = cursor.fetchone()
        cursor.close()

        if row:
            status_db = row['status']
            timestamp_db = row['timestamp_trans']
            local_timezone = pytz.timezone("Asia/Jakarta")
            current_time = datetime.now(local_timezone)
            timestamp_local = local_timezone.localize(timestamp_db)
            if status_db == 'success':
                return {'status': 'Payment Success'}
            else:   
                if current_time - timestamp_local > timedelta(minutes=2):
                    self.set_failed(idTrans)
                    return {'status': 'failed'}
                else:
                    return {'status': 'Still Waiting For Payment'}

    # Add Transaksi into tabel transaksi transfer bank
    def create_trans(self, no_telp, nominal, va):
        print("masuk2")
        print("no_telp2 : ", no_telp)
        print("nominal2 : ", nominal)
        print("va2 : ", va)
        
        status = 'ongoing'
        try:
            cursor = self.connection.cursor(dictionary=True)
            sql = """
            INSERT INTO transbca (
                no_telp, nominal, va, status, timestamp_trans
            ) VALUES (%s, %s, %s, %s, NOW())
            """
            cursor.execute(sql, (no_telp, nominal, va, status))
            self.connection.commit()
            # Ambil id_transaksi dari baris yang baru saja dimasukkan
            id_transaksi = cursor.lastrowid
            
            # Ambil VA dari database setelah INSERT
            sql_select_va = """
            SELECT va FROM transbca WHERE id = %s
            """
            cursor.execute(sql_select_va, (id_transaksi,))
            result = cursor.fetchone()
            
            if result:
                va_from_db = result['va']
                cursor.close()
                return {"id_transaksi": id_transaksi, "va": va_from_db}
            else:
                cursor.close()
                return {"error": "Failed to fetch VA from database"}
        
        except Exception as e:
            return {"error": str(e)}

    # Pay transaksi and set status to success
    def pay_trans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE transbca SET status = 'success', timestamp_trans = NOW()  WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        self.connection.commit()
        cursor.close()
        return {'status': "Status updated to success. Payment is already paid."}

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

    # def get_dependency(self, worker_ctx):
    #     # encryption_key = b'your-encryption-key'  # Ensure this is securely managed
    #     # from cryptography.fernet import Fernet
    #     encryption_key = Fernet.generate_key()
    #     print(encryption_key.decode())
    #     # return DatabaseWrapper(self.connection_pool.get_connection(), encryption_key)