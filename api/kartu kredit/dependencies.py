from nameko.extensions import DependencyProvider
import mysql.connector
from mysql.connector import Error, pooling
import hashlib
from datetime import datetime
import random
import string
import numpy as np
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend
import os
import base64

class EncryptionHelper:
    def __init__(self, key):
        self.key = key

    def encrypt(self, plaintext):
        iv = os.urandom(16)  # Generate a random 16-byte IV
        cipher = Cipher(algorithms.AES(self.key), modes.CFB(iv), backend=default_backend())
        encryptor = cipher.encryptor()
        ciphertext = encryptor.update(plaintext.encode()) + encryptor.finalize()
        encrypted_data = iv + ciphertext
        return base64.b64encode(encrypted_data).decode('utf-8')  # Encode as base64

    def decrypt(self, ciphertext):
        encrypted_data = base64.b64decode(ciphertext)  # Decode from base64
        iv = encrypted_data[:16]
        actual_ciphertext = encrypted_data[16:]
        cipher = Cipher(algorithms.AES(self.key), modes.CFB(iv), backend=default_backend())
        decryptor = cipher.decryptor()
        decrypted_text = decryptor.update(actual_ciphertext) + decryptor.finalize()
        return decrypted_text.decode('utf-8')
    
class DatabaseWrapper:
    connection = None

    def __init__(self, connection, encryption_key):
        self.connection = connection
        self.encryption_helper = EncryptionHelper(encryption_key)

    def hash_nomer_kartu(self, nomer_kartu):
        # Use SHA-256 hash algorithm
        hash_object = hashlib.sha256(nomer_kartu.encode())
        hashed = hash_object.hexdigest()
        return hashed

    def create_kartu(self, nama, nomer_kartu, cvv, expired_year, expired_month, limit_maks, limit_terpakai, status):
        cursor = self.connection.cursor(dictionary=True)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        hashed_cvv = self.hash_nomer_kartu(cvv)
        sql = ("INSERT INTO kartu (nama, nomer_kartu, cvv, expired_year, expired_month, limit_maks, limit_terpakai, status) "
            "VALUES (%s, %s, %s, %s, %s, %s, %s, %s)")

        val = (nama, hashed_nomer_kartu, hashed_cvv, expired_year, expired_month, limit_maks, limit_terpakai, status)
        try:
            cursor.execute(sql, val)
            self.connection.commit()
            cursor.close()
            return True
        except mysql.connector.Error as err:
            print(f"Error: {err}")
            cursor.close()
            return False

    #cek_nomer_kartu untuk create kartu
    def cek_nomer_kartu(self, nomer_kartu):
        cursor = self.connection.cursor(dictionary=True)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        sql = "SELECT * FROM kartu WHERE nomer_kartu = %s"
        cursor.execute(sql, (hashed_nomer_kartu,))
        result = cursor.fetchall()
        cursor.close()
        return True if result else False
    
    #cek apakah kartu valid dan bisa digunakan    
    def get_nomer_kartu(self, nomer_kartu):
        cursor = self.connection.cursor(dictionary=True)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        sql = "SELECT * FROM kartu WHERE nomer_kartu = %s"
        cursor.execute(sql, (hashed_nomer_kartu,))
        result = cursor.fetchall()
        cursor.close()

        if not result:
            return False

        current_year = datetime.now().year
        current_month = datetime.now().month

        status = result[0].get('status')
        expired_year = result[0].get('expired_year')
        expired_month = result[0].get('expired_month')
        limit_terpakai = result[0].get('limit_terpakai')
        limit_maks = result[0].get('limit_maks')

        print("limit_terpakai {}".format(limit_terpakai))
        print("limit_maks {}".format(limit_maks))

        if status == 1:
            if expired_year == current_year and expired_month >= current_month:
                if limit_terpakai == limit_maks:
                    return False
                else:
                    return True
            elif expired_year > current_year:
                if limit_terpakai == limit_maks:
                    return False
                else:
                    return True

        return False
    
    # cek apakah nomer kartu dan cvv sesuai
    def cek_card_cvv(self, nomer_kartu, cvv):
        cursor = self.connection.cursor(dictionary=True)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        hashed_cvv = self.hash_nomer_kartu(cvv)
        sql = "SELECT * FROM kartu WHERE nomer_kartu = %s"
        cursor.execute(sql, (hashed_nomer_kartu,))
        result = cursor.fetchall()
        cursor.close()
        
        cvv = result[0].get('cvv')
        
        if cvv == hashed_cvv:
            return True
        else:
            return False
        
    # cek apakah nomer kartu dan cvv sesuai 
    # def cek_card_cvv(self, nomer_kartu, cvv):
    #     cursor = self.connection.cursor(dictionary=True)
    #     hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
    #     hashed_cvv = self.hash_nomer_kartu(cvv)
    #     sql = "SELECT * FROM kartu WHERE nomer_kartu = %s"
    #     cursor.execute(sql, (hashed_nomer_kartu,))
    #     result = cursor.fetchall()
    #     cursor.close()
        
    #     cvv = result[0].get('cvv')
        
    #     if cvv == hashed_cvv:
    #         return True
    #     else:
    #         return False
    
    # cek apakah nomer kartu dan cvv sesuai 
    def cek_card_cvv(self, nomer_kartu, cvv, nominal):
        cursor = self.connection.cursor(dictionary=True)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        hashed_cvv = self.hash_nomer_kartu(cvv)
        sql = "SELECT * FROM kartu WHERE nomer_kartu = %s"
        cursor.execute(sql, (hashed_nomer_kartu,))
        result = cursor.fetchall()
        cursor.close()
        
        cvv = result[0].get('cvv')
        limit_terpakai = result[0].get('limit_terpakai')
        limit_maks = result[0].get('limit_maks')
        
        if cvv == hashed_cvv:
            if(limit_terpakai + nominal <= limit_maks):
                return True
            else:
                return False
        else:
            return False
                
    def generate_otp(self, length=6):
        otp = np.random.randint(0, 10, length)
        otp_str = ''.join(map(str, otp))
        return otp_str

    def create_transaksi(self, nomer_kartu, nominal, status):
        print("masuk")
        cursor = self.connection.cursor(dictionary=True)
        otp = self.generate_otp()
        encrypted_otp = self.encryption_helper.encrypt(otp)
        
        print("otp {}".format(otp))
        print("encrypted_otp {}".format(encrypted_otp))
        # print("decrypted_otp {}".format(decrypted_otp))
        # hashed_otp = self.hash_nomer_kartu(otp)
        hashed_nomer_kartu = self.hash_nomer_kartu(nomer_kartu)
        timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

        sql = ("INSERT INTO transaksi_kartu (nomer_kartu, nominal, status, otp, timestamp, otp_timestamp) "
               "VALUES (%s, %s, %s, %s, %s, %s)")

        val = (hashed_nomer_kartu, nominal, status, encrypted_otp, timestamp, timestamp)
        try:
            cursor.execute(sql, val)
            self.connection.commit()
            cursor.close()
            return otp
        except mysql.connector.Error as err:
            print(f"Error: {err}")
            cursor.close()
            return None
    
    # get OTP berdasarkan id_transaksi
    def get_otp(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM transaksi_kartu WHERE id_transaksi = %s"
        cursor.execute(sql, (id_transaksi,))
        result = cursor.fetchall()
        cursor.close()
        
        otp = result[0].get('otp')
        decrypted_otp = self.encryption_helper.decrypt(otp)
        
        return decrypted_otp
    
    # cek OTP berdasarkan id_transaksi dan otp user
    def cek_otp(self, id_transaksi, otp):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM transaksi_kartu WHERE id_transaksi = %s"
        cursor.execute(sql, (id_transaksi,))
        result = cursor.fetchall()
        cursor.close()
        
        otpDatabase = result[0].get('otp')
        decrypted_otp = self.encryption_helper.decrypt(otpDatabase)
        
        if(decrypted_otp == otp):
            return True
        else:
            return False
        
    # Update timestamp_otp dan otp berdasarkan id_transaksi 
    def change_otp(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = ("UPDATE transaksi_kartu SET otp = %s, otp_timestamp = %s WHERE id_transaksi= %s")
        otp = self.generate_otp()
        encrypted_otp = self.encryption_helper.encrypt(otp)
        timestamp = datetime.now()
        val = (encrypted_otp, timestamp, id_transaksi)
        
        print("otp {}".format(otp))
        
        try:
            cursor.execute(sql, val)
            self.connection.commit()
            cursor.close()
            return otp
        
        except mysql.connector.Error as err:
            print(f"Error: {err}")
            cursor.close()
            return False

    #cek_nomer_kartu untuk update_card_limit
    def cek_id_transaksi(self, id_transaksi):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM transaksi_kartu WHERE id_transaksi = %s"
        cursor.execute(sql, (id_transaksi,))
        result = cursor.fetchall()
        cursor.close()
        return True if result else False
    
        
    def update_card_limit(self, id_transaksi):
        print("masuk")
        cursor = self.connection.cursor(dictionary=True)

        try:
            # Fetch transaction details
            sql1 = "SELECT * FROM transaksi_kartu WHERE id_transaksi = %s"
            cursor.execute(sql1, (id_transaksi,))
            result = cursor.fetchall()

            if not result:
                print("Transaction not found.")
                return False

            nomer_kartu = result[0].get('nomer_kartu')
            nominal = result[0].get('nominal')

            # Fetch card details
            sql2 = "SELECT * FROM kartu WHERE nomer_kartu = %s"
            cursor.execute(sql2, (nomer_kartu,))
            result2 = cursor.fetchall()

            if not result2:
                print("Card not found.")
                return False

            limit_terpakai = result2[0].get('limit_terpakai')

            # Calculate new limit usage
            total = limit_terpakai + nominal

            print("limit_terpakai {}".format(limit_terpakai))
            print("total {}".format(total))

            # Update card limit usage
            sql = "UPDATE kartu SET limit_terpakai = %s WHERE nomer_kartu = %s"
            val = (total, nomer_kartu)

            cursor.execute(sql, val)
            self.connection.commit()

            return True

        except mysql.connector.Error as err:
            print(f"Error: {err}")
            return False

        finally:
            cursor.close()

    def update_status_transaksi(self, id_transaksi, status):
        print("masuk")
        cursor = self.connection.cursor(dictionary=True)

        try:
            # Check if the transaction exists
            sql = "SELECT * FROM transaksi_kartu WHERE id_transaksi = %s"
            cursor.execute(sql, (id_transaksi,))
            result = cursor.fetchall()

            if not result:
                print("Transaction not found.")
                return False

            # Update the transaction status
            sql = "UPDATE transaksi_kartu SET status = %s WHERE id_transaksi = %s"
            val = (status, id_transaksi)

            cursor.execute(sql, val)
            self.connection.commit()
            
            print("id_transaksi {}".format(id_transaksi))
            print("status {}".format(status))
            
            return True

        except mysql.connector.Error as err:
            print(f"Error: {err}")
            return False

        finally:
            cursor.close()


    
class Database(DependencyProvider):
    encryption_key = b'\x01\x23\x45\x67\x89\xab\xcd\xef\x01\x23\x45\x67\x89\xab\xcd\xef\x01\x23\x45\x67\x89\xab\xcd\xef\x01\x23\x45\x67\x89\xab\xcd\xef'
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
        connection = self.connection_pool.get_connection()
        return DatabaseWrapper(connection, self.encryption_key)
     

    
    
    
    
