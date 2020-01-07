# 自定义laravel 的用户认证功能

## 使用方式
1. 配置好对应的composer.json:
    ```json
    {
     "repositories": [
            {
                "type": "path",
                "url": "./packages/laravel-custom-auth"
            }
        ]
     }
    ```
2. 建立好本地厂库
3. 安装项目
    ```sh
    composer require melody-wen/laravel-custom-auth "dev-master"
    ```
 
4. 配置auth.php 配置文件
    ```PHP
    [
       'guards' => [
                   'my-guard' => [
                       'driver' => 'custom-guard',
                       'provider' => 'my-user-provider',
                       'inputKey' => '',
                       'storageKey' => ''
                   ]
               ],
       'providers' => [
           'my-user-provider' => [
               'driver' => 'custom-user-provider',
               'class' => '',
           ]
       ],
    ]
     
    ```