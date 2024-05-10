# Export Navicat

通过 Navicat 备份文件读取连接信息和解析密码。

## 安装

```bash
composer create-project sy-records/export-navicat
```

## 使用

```bash
cd export-navicat

# 获取连接信息
php navicat data -f db.ncx

# 获取明文密码
php navicat decode --pwd 848DDD89C27CA7FC3DF6FED293421464
```
