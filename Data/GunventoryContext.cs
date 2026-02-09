using Microsoft.EntityFrameworkCore;
using Gunventory.Models;

namespace Gunventory.Data;

public class GunventoryContext : DbContext
{
    public GunventoryContext(DbContextOptions<GunventoryContext> options)
        : base(options)
    {
    }

    public DbSet<Role> Roles { get; set; } = null!;
    public DbSet<User> Users { get; set; } = null!;
    public DbSet<GunType> GunTypes { get; set; } = null!;
    public DbSet<Caliber> Calibers { get; set; } = null!;
    public DbSet<Firearm> Firearms { get; set; } = null!;
    public DbSet<Ammunition> Ammunitions { get; set; } = null!;
    public DbSet<ShootingType> ShootingTypes { get; set; } = null!;
    public DbSet<ShootingActivity> ShootingActivities { get; set; } = null!;
    public DbSet<MaintenanceType> MaintenanceTypes { get; set; } = null!;
    public DbSet<Maintenance> Maintenance { get; set; } = null!;
    public DbSet<Accessory> Accessories { get; set; } = null!;
    public DbSet<MalfunctionType> MalfunctionTypes { get; set; } = null!;
    public DbSet<Malfunction> Malfunctions { get; set; } = null!;

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.Entity<User>()
            .HasIndex(u => u.Username)
            .IsUnique();

        modelBuilder.Entity<User>()
            .HasIndex(u => u.Email)
            .IsUnique();

        modelBuilder.Entity<Firearm>()
            .HasIndex(f => f.Serial)
            .IsUnique();

        // Seed data will be handled by a separate initializer for better control
    }
}
