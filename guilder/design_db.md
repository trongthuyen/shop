# Thiết kế database

1. Bảng quyền -> role
    - id: int -> khóa tự tăng
    - name: string -> 50 ký tự
2. Bảng quản lý tài khoản -> user
    - id: int -> khóa tự tăng
    - fullname: string -> 50 ký tự
    - email: string -> 100 ký tự
    - password: string -> 300 ký tự (Nhu cầu bảo mật)
    - phone_number: string -> 20 ký tự
    - address: string -> 200 ký tự
    - role_id: int -> tham chiếu -> role (id)
    - created_at: datetime
    - updated_at: datetime
    - is_deleted
3. Bảng quản lý -> category
    - id: int -> khóa tự tăng
    - name: string -> 100 ký tự
    - is_deleted
4. Bảng sản phẩm -> Product
    - id: int -> khóa tự tăng
    - category_id: int -> tham chiếu -> category (id)
    - title: string -> 300 ký tự
    - price: int
    - discount: int
    - thumbnail: string -> 500 ký tự
    - description: longtext
    - created_at: datetime
    - updated_at: datetime
    - is_deleted
5. Bảng quản lý phản hồi -> feedback
    - id: int -> khóa tự tăng
    - user_id: int -> tham chiếu -> user
    - product_id: int -> tham chiếu -> product
    - content: string -> 500 ký tự
    - created_at: datetime
    - updated_at: datetime
    - is_seen
    - marked
6. Bảng quản lý đơn hàng -> orders
    - id: int: khóa tự tăng
    - user_id: int -> tham chiếu ->user
    - product_id: int -> tham chiếu -> product
    - quantity: int
    - phone_number: string
    - address: string
    - note : string
    - order_date: datetime
    - status
    - total_money: int
7. Bảng lưu thông tin tài khoản đang đăng nhập -> token
    - user_id: int -> tham chiếu -> user(id)
    -> toke: string