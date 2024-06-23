from nameko.rpc import rpc
import dependencies

class KartuService:

    name = 'kartu_service'

    database = dependencies.Database()

    @rpc
    def hello(self):
        return "Hello,!"

    @rpc
    def create_kartu(self, nama, nomer_kartu, cvv, expired_year, expired_month, limit_maks, limit_terpakai, status):
        if not self.database.cek_nomer_kartu(nomer_kartu):
            success = self.database.create_kartu(nama, nomer_kartu, cvv, expired_year, expired_month, limit_maks, limit_terpakai, status)
            if success:
                return {
                    'code': 200,
                    'data': 'Card created successfully'
                }
            else:
                return {
                    'code': 500,
                    'data': 'Failed to create card'
                }
        else:
            return {
                'code': 404,
                'data': 'Card number is already in the database'
            }

    @rpc
    def cek_nomer_kartu(self, nomer_kartu):
        card_exists = self.database.cek_nomer_kartu(nomer_kartu)
        if not card_exists:
            return {
                'code': 404,
                'data': 'nomer_kartu is not in the database'
            }
        return card_exists
    
    #cek apakah kartu valid dan bisa digunakan
    @rpc
    def get_nomer_kartu(self, nomer_kartu):
        success = self.database.get_nomer_kartu(nomer_kartu)
        if success:
            return {
                'code': 200,
                'data': success
            }
        else:
            return {
                'code': 500,
                'data': success
            }
    
    #cek apakah nomer kartu dan cvv sesuai
    # @rpc
    # def cek_card_cvv(self, nomer_kartu, cvv,):
    #     return self.database.cek_card_cvv(nomer_kartu, cvv)
    
    #cek apakah inputan user sudah sesuai, apakah limit tidak lebih dan blm expired
    @rpc
    def cek_card_cvv(self, nomer_kartu, cvv, nama, month, year, nominal):
        try:
            # Call database method to check card details
            success = self.database.cek_card_cvv(nomer_kartu, cvv, nama, month, year, nominal)
            
            if success and isinstance(success, dict) and 'otp' in success and 'inserted_id' in success:
                return {
                    'code': 200,
                    'data': {
                        'otp': success['otp'],
                        'id_transaksi': success['inserted_id']
                    }
                }
            else:
                return {
                    'code': 500,
                    'data': success
                }
        except Exception as e:
            # Handle exceptions or errors here
            print(f"Error in cek_card_cvv_rpc: {e}")
            return {
                'code': 500,
                'data': str(e)  # Return error message as string
            }
            
    #create skalian buat otp
    @rpc
    def create_transaksi(self, nomer_kartu, nominal, status):
        success = self.database.create_transaksi(nomer_kartu, nominal, status)
        print("success {}".format(success))
        if success:
            return {
                'code': 200,
                'data': success
            }
        else:
            return {
                'code': 500,
                'data': 'Failed to create transaction'
            }
    
    # get OTP berdasarkan id_transaksi    
    # @rpc
    # def get_otp(self, id_transaksi):
    #     otp = self.database.get_otp(id_transaksi)
    #     return {
    #             'code': 200,
    #             'data': otp
    #         }
    
    # get all data berdasarkan id_transaksi
    @rpc
    def get_data_Tkartu(self, id_transaksi):
        data = self.database.get_data_Tkartu(id_transaksi)
        return {
                'code': 200,
                'data': data
            }
    
    # cek OTP berdasarkan id_transaksi dan otp user   
    @rpc
    def cek_otp(self, id_transaksi,otp):
        otp = self.database.cek_otp(id_transaksi,otp)
        if otp:
            return {
                    'code': 200,
                    'data': True
                }
        else :
            return {
                'code': 404,
                'data': False
            }
    
    # Update timestamp_otp dan otp berdasarkan id_transaksi 
    @rpc
    def change_otp(self, id_transaksi):
        otp = self.database.change_otp(id_transaksi)
        if otp:
            return {
                    'code': 200,
                    'data': otp
                }
        else :
            return {
                'code': 404,
                'data': False
            }
            
    
    # Update attempt
    @rpc
    def update_attempt(self, id_transaksi):
        attempt = self.database.update_attempt(id_transaksi)
        if attempt:
            return {
                    'code': 200,
                    'data': True
                }
        else :
            return {
                'code': 404,
                'data': False
            }
            
    # cek apakah id_transaksi ada        
    @rpc
    def cek_id_transaksi(self, id_transaksi):
        id_exists = self.database.cek_id_transaksi(id_transaksi)
        if not id_exists:
            return {
                'code': 404,
                'data': 'id_transaksi is not in the database'
            }
        return id_exists
    
    #update status dan limit transaksi berdasarkan id_transaksi
    @rpc
    def update_status_transaksi(self, id_transaksi, status):
        # Check if the transaction exists
        if not self.database.cek_id_transaksi(id_transaksi):
            return {
                'code': 404,
                'data': False
            }

        success = self.database.update_status_transaksi(id_transaksi, status)
        
        if not success:
            return {
                'code': 500,
                'data': False
            }

        if status.lower() == 'success':
            limit_success = self.database.update_card_limit(id_transaksi)
            if not limit_success:
                return {
                    'code': 500,
                    'data': False
                }
        
        return {
            'code': 200,
            'data': True
        }

                