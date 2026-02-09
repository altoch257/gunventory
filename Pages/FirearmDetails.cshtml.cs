using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class FirearmDetailsModel : PageModel
{
    private readonly GunventoryContext _context;

    public FirearmDetailsModel(GunventoryContext context)
    {
        _context = context;
    }

    public Firearm Firearm { get; set; } = default!;
    public int TotalRoundsFired { get; set; }
    public decimal TotalAccessoriesPrice { get; set; }
    public decimal GrandTotal { get; set; }
    public List<AmmoInventoryViewModel> AvailableAmmo { get; set; } = new();
    public List<ShootingActivity> ShootingActivities { get; set; } = new();
    public List<Maintenance> MaintenanceRecords { get; set; } = new();
    public List<Accessory> Accessories { get; set; } = new();
    public List<Malfunction> Malfunctions { get; set; } = new();

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        Firearm = await _context.Firearms
            .Include(f => f.GunType)
            .Include(f => f.Caliber)
            .FirstOrDefaultAsync(m => m.Id == id);

        if (Firearm == null)
        {
            return NotFound();
        }

        TotalRoundsFired = await _context.ShootingActivities
            .Where(sa => sa.FirearmId == id && sa.Status == "A")
            .SumAsync(sa => sa.RoundsFired);

        TotalAccessoriesPrice = await _context.Accessories
            .Where(a => a.FirearmId == id && a.Status == "A")
            .SumAsync(a => a.Price);

        GrandTotal = Firearm.Price + TotalAccessoriesPrice;

        AvailableAmmo = await _context.Ammunitions
            .Where(a => a.GunTypeId == Firearm.GunTypeId && a.Status == "A")
            .GroupBy(a => a.Manufacturer)
            .Select(g => new AmmoInventoryViewModel
            {
                Manufacturer = g.Key,
                TotalRounds = g.Sum(a => a.Rounds),
                RoundsFired = _context.ShootingActivities
                    .Where(sa => sa.Ammunition.Manufacturer == g.Key && sa.Ammunition.GunTypeId == Firearm.GunTypeId && sa.Subtract)
                    .Sum(sa => sa.RoundsFired)
            })
            .ToListAsync();

        ShootingActivities = await _context.ShootingActivities
            .Include(sa => sa.ShootingType)
            .Where(sa => sa.FirearmId == id && sa.Status == "A")
            .OrderByDescending(sa => sa.ShootingDate)
            .ToListAsync();

        MaintenanceRecords = await _context.Maintenance
            .Include(m => m.MaintenanceType)
            .Where(m => m.FirearmId == id && m.Status == "A")
            .OrderByDescending(m => m.Date)
            .ToListAsync();

        Accessories = await _context.Accessories
            .Where(a => a.FirearmId == id && a.Status == "A")
            .OrderBy(a => a.Model)
            .ToListAsync();

        Malfunctions = await _context.Malfunctions
            .Include(m => m.MalfunctionType)
            .Where(m => m.FirearmId == id && m.Status == "A")
            .OrderByDescending(m => m.MalfunctionDate)
            .ToListAsync();

        return Page();
    }

    public class AmmoInventoryViewModel
    {
        public string Manufacturer { get; set; } = string.Empty;
        public int TotalRounds { get; set; }
        public int RoundsFired { get; set; }
        public int Available => TotalRounds - RoundsFired;
    }
}
