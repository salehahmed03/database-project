
create procedure SalaryRaise(@Raise int , @ID int )
as
begin
Update Staff
set salary = salary + salary*(@Raise/100)
where Staff.ID = @ID

select Fname,Lname,SSN, ID, Salary as "Updated Salary" from Staff
where ID =@ID 
end;
--SalaryRaise Test
exec SalaryRaise @Raise= 20, @ID = 1


--SalaryDeduction
create procedure SalaryDeduction(@Deduction int , @ID int )
as
begin
Update Staff
set salary = salary - salary*(@Deduction/100)
where Staff.ID = @ID
select Fname,Lname,SSN, ID, Salary as "Updated Salary" from Staff
where ID =@ID 
end; 
--SalaryDeduction Test
exec SalaryDeduction @Deduction= 20, @ID = 1

--AddAnimal
create procedure AddAnimal(@Animal_Name varchar(50),@Gender varchar(1),@Habitat varchar(50),@General_Name varchar(50),@Genus varchar(50),@Species varchar(50),@Status varchar(50),@Diet_Type varchar(50),@Date_of_Birth Date,@FamilyTree int = NULL,@Exhibit_no int)
as
begin
    insert into Animal (Animal_Name, Gender, Habitat, General_Name, Genus, Species, Status, Diet_Type, Date_of_Birth,Family_Tree, Exhibit_no)
    values (@Animal_Name, @Gender, @Habitat, @General_Name, @Genus, @Species, @Status, @Diet_Type, @Date_of_Birth,@FamilyTree, @Exhibit_no)
    select * from Animal
end;
--AddAnimal Test
exec AddAnimal @Animal_Name = 'Mosaad', @Gender = 'M', @Habitat = 'Savannah', @General_Name = 'Zebra', @Genus = 'Equus', @Species = 'Zebra', @Status = 'Healthy', @Diet_Type = 'Herbivore', @Date_of_Birth = '2019-01-01', @Exhibit_no = 3

--TransferAnimal
create procedure TransferAnimal(
    @Animal_ID int,
    @Exhibit_no int)
as
begin
    if (select count(*) from Animal where Exhibit_no = @Exhibit_no) < (select Capacity from Exhibit where Exhibit_no = @Exhibit_no)
    begin
        update Animal
        set Exhibit_no = @Exhibit_no
        where Animal_ID = @Animal_ID;
        select Animal_ID, Exhibit_no from Animal where Animal_ID = @Animal_ID;
    end
    else
    begin
        print 'The exhibit is at full capacity. The animal cannot be transferred.';
    end
end;
--TransferAnimal Test
exec TransferAnimal @Animal_ID = 1, @Exhibit_no = 2

--Check if the input id is a manager
go
CREATE FUNCTION IsManager (@staff_id INT)
RETURNS BIT AS
BEGIN
    IF EXISTS (SELECT ID FROM Staff WHERE ID = @staff_id AND Manager_ID IS NULL)
        RETURN 1;
    
	RETURN 0;
END;

--Find a substitutional ClinicManager
go
CREATE FUNCTION FindClinicManager (@input_id INT)
RETURNS INT AS
BEGIN
    RETURN (SELECT TOP 1 ID FROM Staff WHERE Role = 'Clinic Manager' AND dbo.IsManager(ID) = 1 AND ID <> @input_id);
END;

--Find a substitutional ShopManager
go
CREATE FUNCTION FindShopManager (@input_id INT)
RETURNS INT AS
BEGIN
    RETURN (SELECT TOP 1 ID FROM Staff WHERE Role = 'Shop Manager' AND dbo.IsManager(ID) = 1 AND ID <> @input_id);
END;

--Find a substitutional ExhibitAdvisor
go
CREATE FUNCTION FindExhibitAdvisor (@input_id INT)
RETURNS INT AS
BEGIN
    RETURN (SELECT TOP 1 ID FROM Staff WHERE Role = 'Exhibit Advisor' AND dbo.IsManager(ID) = 1 AND ID <> @input_id);
END;

--Delete an employee
go
CREATE PROCEDURE FireStaff @input_id INT AS
BEGIN
    IF dbo.IsManager(@input_id) = 0
    BEGIN
		DELETE FROM Staff_Phone WHERE Staff_ID = @input_id;
        DELETE FROM Staff WHERE ID = @input_id;
    END
    ELSE
    BEGIN
        DECLARE @role VARCHAR(50), @new_manager_id INT;

        SELECT @role = Role FROM Staff WHERE ID = @input_id;

        IF @role = 'Exhibit Advisor'
            SET @new_manager_id = dbo.FindExhibitAdvisor(@input_id);
        ELSE IF @role = 'Clinic Manager'
            SET @new_manager_id = dbo.FindClinicManager(@input_id);
        ELSE IF @role = 'Shop Manager'
            SET @new_manager_id = dbo.FindShopManager(@input_id);

        IF @new_manager_id IS NULL
        BEGIN
            RAISERROR('Cannot delete the manager because there is no replacement.', 16, 1);
            RETURN;
        END

		UPDATE Staff SET Manager_ID = @new_manager_id WHERE Manager_ID = @input_id;

		IF @role = 'Exhibit Advisor'
            UPDATE Exhibit SET EManager_Id = @new_manager_id WHERE EManager_Id = @input_id;
        ELSE IF @role = 'Clinic Manager'
            UPDATE Clinic SET CManager_Id = @new_manager_id WHERE CManager_Id = @input_id;
        ELSE IF @role = 'Shop Manager'
            UPDATE Shop SET SManager_Id = @new_manager_id WHERE SManager_Id = @input_id;

		DELETE FROM Staff_Phone WHERE Staff_ID = @input_id;
        DELETE FROM Staff WHERE ID = @input_id;
    END
	select * from staff;
END;

--Add Staff
go
CREATE PROCEDURE HireStaff 
    @Manager_ID INT, 
    @Clinic_NO INT, 
    @Exhibit_NO INT, 
    @Shop_NO INT, 
    @SSN VARCHAR(10), 
    @Fname VARCHAR(50), 
    @Mname VARCHAR(50), 
    @Lname VARCHAR(50), 
    @Address VARCHAR(100), 
    @Email VARCHAR(100), 
    @Salary DECIMAL(10, 2), 
    @Gender CHAR(1), 
    @Role VARCHAR(50), 
    @Joining_Date DATE, 
    @Birth_Date DATE, 
    @Working_Hours VARCHAR(50)
AS
BEGIN
    INSERT INTO Staff 
    (Manager_ID, Clinic_NO, Exhibit_NO, Shop_NO, SSN, Fname, Mname, Lname, Address, Email, Salary, Gender, Role, Joining_Date, Birth_Date, Working_Hours)
    VALUES 
    (@Manager_ID, @Clinic_NO, @Exhibit_NO, @Shop_NO, @SSN, @Fname, @Mname, @Lname, @Address, @Email, @Salary, @Gender, @Role, @Joining_Date, @Birth_Date, @Working_Hours);
    SELECT * FROM Staff;
END;

--Promote staff
go
CREATE PROCEDURE PromoteStaff @staff_id INT AS
BEGIN
    DECLARE @current_role VARCHAR(50);
    SELECT @current_role = Role FROM Staff WHERE ID = @staff_id;

    IF @current_role = 'Janitor'
        UPDATE Staff SET Role = 'Security Guard' WHERE ID = @staff_id;
    ELSE IF @current_role = 'Security Guard'
        UPDATE Staff SET Role = 'Exhibit Advisor', Manager_ID = NULL WHERE ID = @staff_id;
    ELSE IF @current_role = 'Shop Attendant'
        UPDATE Staff SET Role = 'Shop Manager', Manager_ID = NULL WHERE ID = @staff_id;
    ELSE IF @current_role = 'Zookeeper'
        UPDATE Staff SET Role = 'Exhibit Advisor', Manager_ID = NULL WHERE ID = @staff_id;
    ELSE IF @current_role = 'Veterinarian'
        UPDATE Staff SET Role = 'Clinic Manager', Manager_ID = NULL WHERE ID = @staff_id;
	ELSE IF @current_role = 'Cafeteria Staff'
        UPDATE Staff SET Role = 'Shop Manager', Manager_ID = NULL WHERE ID = @staff_id;

    SELECT * FROM Staff;
END;

--Get staff role
go
CREATE FUNCTION GetStaffRole (@staff_id INT)
RETURNS VARCHAR(50) AS
BEGIN
    DECLARE @role VARCHAR(50);
    SELECT @role = Role FROM Staff WHERE ID = @staff_id;
    RETURN @role;
END;

--Add clinic
go
CREATE PROCEDURE AddClinic 
    @Location VARCHAR(50), 
    @Capacity INT, 
    @Operating_Hours VARCHAR(30), 
    @Event_Type VARCHAR(50), 
    @Event_Date DATE, 
    @CManager_Id INT
AS
BEGIN
    IF @Event_Type NOT IN ('Check-Up', 'Surgery')
    BEGIN
        RAISERROR('Invalid type. It should be either "Check-Up" or "Surgery".', 16, 1);
        RETURN;
    END

    INSERT INTO Clinic (Location, Capacity, Operating_Hours, Event_Type, Event_Date, CManager_Id) 
    VALUES (@Location, @Capacity, @Operating_Hours, @Event_Type, @Event_Date, @CManager_Id);
END;