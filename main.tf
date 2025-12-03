provider "aws" {
  region = "us-east-1"
}

# --- 1. SSH Key Generation (So you can log in) ---
resource "tls_private_key" "pk" {
  algorithm = "RSA"
  rsa_bits  = 4096
}

resource "aws_key_pair" "kp" {
  key_name   = "my-library-key-final"
  public_key = tls_private_key.pk.public_key_openssh
}

# Save the private key to a file on your computer
resource "local_file" "ssh_key" {
  filename = "my-library-key-final.pem"
  content  = tls_private_key.pk.private_key_pem
}

# --- 2. Security Groups (Firewalls) ---
resource "aws_security_group" "web_sg" {
  name        = "library-web--final"
  description = "Allow HTTP and SSH"

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_security_group" "db_sg" {
  name        = "library-db-sg-final"
  description = "Allow PostgreSQL from Anywhere"

  ingress {
    from_port       = 5432
    to_port         = 5432
    protocol        = "tcp"
    cidr_blocks     = ["0.0.0.0/0"] # Only allow the web server
  }
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

# --- 3. The Database (RDS) ---
resource "aws_db_instance" "default" {
  allocated_storage      = 20
  engine                 = "postgres"
  engine_version         = "16.3" # Check available versions if this fails
  instance_class         = "db.t3.micro" # Free tier eligible
  db_name                = "library_db"
  username               = "postgres"
  password               = "swagpapi101" # CHANGE THIS PASSWORD!
  parameter_group_name   = "default.postgres16"
  skip_final_snapshot    = true
  publicly_accessible    = true
  vpc_security_group_ids = [aws_security_group.db_sg.id]
}

# --- 4. The Server (EC2) ---
resource "aws_instance" "web" {
  ami           = "ami-04a81a99f5ec58529" # Ubuntu 24.04 LTS (us-east-1)
  instance_type = "t3.micro"
  key_name      = aws_key_pair.kp.key_name
  security_groups = [aws_security_group.web_sg.name]

  # This script runs ONCE when the server starts
  user_data = <<-EOF
              #!/bin/bash
              # Install Docker
              apt-get update
              apt-get install -y docker.io
              systemctl start docker
              systemctl enable docker

              # Add user to docker group
              usermod -aG docker ubuntu

              # Pull Arfi's Image
              docker pull ghcr.io/afrirahman/pso-final-library-management/laravel:latest

              # Run the Container with RDS Connection Details
              docker run -d \
                --name laravel-app \
                -p 80:80 \
                -e APP_ENV=production \
                -e APP_KEY=base64:base64:kKsHYNE5FSdNiskBn4try7WiilmbpODYVuzknw8iOyI= \
                -e APP_DEBUG=true \
                -e DB_CONNECTION=pgsql \
                -e DB_HOST=${aws_db_instance.default.address} \
                -e DB_PORT=5432 \
                -e DB_DATABASE=library_db \
                -e DB_USERNAME=postgres \
                -e DB_PASSWORD=swagpapi101 \
                ghcr.io/afrirahman/pso-final-library-management/laravel:latest
              EOF

  tags = {
    Name = "Library-App-Server"
  }
}

# --- 5. Output the Info You Need ---
output "website_ip" {
  value = "http://${aws_instance.web.public_ip}"
}

output "rds_endpoint" {
  value = aws_db_instance.default.address
}