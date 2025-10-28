# Serial check
1. Send request to GRC serial management with serial licence number
2. Deccrypt data from response object using **company algorithm** and **company key** default (These are set before)
3. If there is an error return with error else continue
4. If first time catch server time (TODO catch current date from request) and write it in `vendor/laravel/framework/src/Illuminate/Encryption/t` path
5. Decode deccrypt data in step2 and  use `d` , `m` data to write it in `vendor/laravel/framework/src/Illuminate/Encryption/ed` and `vendor/laravel/framework/src/Illuminate/Encryption/am` paths

# Non serial routes protected by `ValidateSerialMiddleware`
1. Try reading **`t` catch time file**, **`ed` expiration date file**, and **`am` algorithm meta data encryption/decryption as ***cipher_algo*** and ***cipher_algo_key*** file** for checking file exsitence
2. Check if the first time redirect to serial view else continue
3. Decrypt data from `am` file using **company algorithm** and **company key** default (These are set before)
4. Decrypt data of `t` and `ed` files using **serial algorithm** and **serial key**
5. Check if server date was changed or set current time if greater than old time
6. Check expiration date

# Serial routes protected by `InvalidateSerialMiddleware`
1. Try reading **`t` catch time file**, **`ed` expiration date file**, and **`am` algorithm meta data encryption/decryption as ***cipher_algo*** and ***cipher_algo_key*** file**
2. Check if the first time redirect to serial view else continue
3. Decrypt data from `am` file using **company algorithm** and **company key** default (These are set before)
4. Decrypt data of `t` and `ed` files using **serial algorithm** and **serial key**
5. Check if server date was changed or set current time if greater than old time
6. Check expiration date
