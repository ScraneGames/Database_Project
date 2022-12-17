ALTER TABLE physicians DROP foreign key fk_physician_Position;

ALTER TABLE physicians DROP foreign key fk_physician_Employee_name

ALTER TABLE physicians ADD CONSTRAINT `fk_physician_Position`
    ->     FOREIGN KEY (`position`)
    ->     REFERENCES `Project_DB`.`staff` (`position`)
    ->     ON DELETE NO ACTION
    ->     ON UPDATE NO ACTION;

    ALTER TABLE physicians ADD CONSTRAINT `fk_physician_Employee_Name`
    ->     FOREIGN KEY (`employee_name`)
    ->     REFERENCES `Project_DB`.`staff` (`employee_name`)
    ->     ON DELETE NO ACTION
    ->     ON UPDATE NO ACTION);
