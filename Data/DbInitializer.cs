using Gunventory.Models;
using BCrypt.Net;

namespace Gunventory.Data;

public static class DbInitializer
{
    public static void Initialize(GunventoryContext context)
    {
        context.Database.EnsureCreated();

        if (context.Roles.Any())
        {
            return;   // DB has been seeded
        }

        var roles = new Role[]
        {
            new Role { Name = "Administration", Status = "A", STimestamp = DateTime.Now },
            new Role { Name = "Human Resources", Status = "A", STimestamp = DateTime.Now },
            new Role { Name = "Business Development", Status = "A", STimestamp = DateTime.Now },
            new Role { Name = "Customer Service", Status = "A", STimestamp = DateTime.Now },
            new Role { Name = "Users", Status = "A", STimestamp = DateTime.Now }
        };

        context.Roles.AddRange(roles);
        context.SaveChanges();

        var adminRole = roles.First(r => r.Name == "Administration");

        var adminUser = new User
        {
            FirstName = "System Admin",
            LastName = "",
            Email = "altoch@hotmail.com",
            Phone = "(848) 456-0660",
            Username = "xadmin",
            Password = BCrypt.Net.BCrypt.HashPassword("Burr1t0L0c0"),
            RoleId = adminRole.Id,
            Status = "A",
            STimestamp = DateTime.Now
        };

        context.Users.Add(adminUser);
        context.SaveChanges();

        var gunTypes = new GunType[]
        {
            new GunType { Name = "Handgun", Status = "A", STimestamp = DateTime.Now },
            new GunType { Name = "Rifle", Status = "A", STimestamp = DateTime.Now },
            new GunType { Name = "Shotgun", Status = "A", STimestamp = DateTime.Now }
        };
        context.GunTypes.AddRange(gunTypes);

        var calibers = new Caliber[]
        {
            new Caliber { Name = "9 mm", Status = "A", STimestamp = DateTime.Now },
            new Caliber { Name = ".223/.556", Status = "A", STimestamp = DateTime.Now },
            new Caliber { Name = ".380 ACP", Status = "A", STimestamp = DateTime.Now },
            new Caliber { Name = ".38 Special", Status = "A", STimestamp = DateTime.Now },
            new Caliber { Name = ".40 S&W", Status = "A", STimestamp = DateTime.Now },
            new Caliber { Name = ".45 ACP", Status = "A", STimestamp = DateTime.Now }
        };
        context.Calibers.AddRange(calibers);

        var shootingTypes = new ShootingType[]
        {
            new ShootingType { Name = "Outdoor Range", Status = "A" },
            new ShootingType { Name = "Indoor Range", Status = "A" },
            new ShootingType { Name = "Outing / Off-Grrid", Status = "A" },
            new ShootingType { Name = "Hunting", Status = "A" },
            new ShootingType { Name = "Other", Status = "A" }
        };
        context.ShootingTypes.AddRange(shootingTypes);

        var maintenanceTypes = new MaintenanceType[]
        {
            new MaintenanceType { Name = "Refreshed EDC Defense Rounds", Status = "A" },
            new MaintenanceType { Name = "Complete Breakdown Cleaning", Status = "A" },
            new MaintenanceType { Name = "Field Strip", Status = "A" },
            new MaintenanceType { Name = "Zeroed Optics", Status = "A" },
            new MaintenanceType { Name = "Other", Status = "A" }
        };
        context.MaintenanceTypes.AddRange(maintenanceTypes);

        var malfunctionTypes = new MalfunctionType[]
        {
            new MalfunctionType { Name = "Double-Feed", Status = "A" },
            new MalfunctionType { Name = "Failure to Eject: Stovepipe", Status = "A" },
            new MalfunctionType { Name = "Failure to Extract", Status = "A" },
            new MalfunctionType { Name = "Failure to Fire: Hangfire", Status = "A" },
            new MalfunctionType { Name = "Failure to Fire: Light Stike", Status = "A" },
            new MalfunctionType { Name = "Failure to Fire: Squib Load", Status = "A" },
            new MalfunctionType { Name = "Tip-Up", Status = "A" },
            new MalfunctionType { Name = "Other", Status = "A" }
        };
        context.MalfunctionTypes.AddRange(malfunctionTypes);

        context.SaveChanges();
    }
}
