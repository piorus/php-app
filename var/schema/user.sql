DROP TABLE IF EXISTS "user";
DROP TYPE IF EXISTS user_role;
CREATE TYPE user_role AS ENUM ('USER', 'ADMIN');
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    nickname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    role user_role
);
INSERT INTO "user" (nickname, email, password, role) VALUES ('admin', 'admin@example.com', '$argon2id$v=19$m=65536,t=4,p=1$U3YvVWZpa3EvWXMyd1VDdw$eGgd4NQb1CwvkR+nXgr1/TNOE5SsqiFR8u8CXhKqZ88', 'ADMIN');
