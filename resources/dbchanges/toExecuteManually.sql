
SET SQL_SAFE_UPDATES = 0;

UPDATE student st JOIN section sc ON st.section_id = sc.id SET st.schoolyear_id = sc.schoolyear_id ;

SET SQL_SAFE_UPDATES = 1;
