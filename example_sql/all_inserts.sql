INSERT INTO people
    (name, position, teams)
VALUES
    ("Vätten Pei", "CEO", "SQUAAAH"),
    ("Johan StrömDröm", "COO", "SQUAAAH"),
    ("Mattias Bergström", "CTO", "SQUAAAH, TRIPODS"),
    ("Osten Stigeborn", "HoSD", "SQUAAAH"),
    ("Paddingtone Almgren", "HoPS", "SQUAAAH"),
    ("David Fikasson", "HoD", "TRIPODS"),
    ("Patrik Pimpdelius", "HoCD", "TRIPODS");

INSERT INTO facility
    (name)
VALUES
    ("S"),
    ("F"),
    ("K"),
    ("D"),
    ("E");

INSERT INTO room
    (name, facility)
VALUES
    ("S143", 1),
    ("S101", 1),
    ("F002", 2),
    ("F097", 2),
    ("K023", 3),
    ("K321", 3),
    ("D073", 4),
    ("D055", 4),
    ("E077", 5),
    ("E030", 5);

INSERT INTO team
    (name)
VALUES
    ("SQUAAAH"),
    ("TRIPODS");

INSERT INTO business_people
        (name, company, position)
VALUES
        ("Don McTrump", "Evil Corp", "CEO"),
        ("Jeebus Kristi", "Nice Corp", "CEO"),
        ("Big boy", "Food Corp", "COO");
