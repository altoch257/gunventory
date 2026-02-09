using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class IndexModel : PageModel
{
    private readonly GunventoryContext _context;

    public IndexModel(GunventoryContext context)
    {
        _context = context;
    }

    public IList<FirearmViewModel> Firearms { get;set; } = default!;

    public async Task OnGetAsync()
    {
        Firearms = await _context.Firearms
            .Where(f => f.Status == "A")
            .Include(f => f.GunType)
            .Include(f => f.Caliber)
            .Select(f => new FirearmViewModel
            {
                Id = f.Id,
                Manufacturer = f.Manufacturer,
                Model = f.Model,
                Caliber = f.Caliber.Name,
                PurchaseDate = f.PurchaseDate,
                ImgURL = f.ImgURL,
                LastShootingActivity = _context.ShootingActivities
                    .Where(sa => sa.FirearmId == f.Id && sa.Status == "A")
                    .OrderByDescending(sa => sa.ShootingDate)
                    .Select(sa => (DateTime?)sa.ShootingDate)
                    .FirstOrDefault(),
                LastMaintenance = _context.Maintenance
                    .Where(m => m.FirearmId == f.Id && m.Status == "A")
                    .OrderByDescending(m => m.Date)
                    .Select(m => (DateTime?)m.Date)
                    .FirstOrDefault()
            })
            .ToListAsync();
    }

    public class FirearmViewModel
    {
        public int Id { get; set; }
        public string Manufacturer { get; set; } = string.Empty;
        public string Model { get; set; } = string.Empty;
        public string Caliber { get; set; } = string.Empty;
        public DateTime PurchaseDate { get; set; }
        public string? ImgURL { get; set; }
        public DateTime? LastShootingActivity { get; set; }
        public DateTime? LastMaintenance { get; set; }
    }
}
