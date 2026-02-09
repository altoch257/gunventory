using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddShootingModel : PageModel
{
    private readonly GunventoryContext _context;

    public AddShootingModel(GunventoryContext context)
    {
        _context = context;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList Firearms { get; set; } = default!;
    public SelectList Ammunitions { get; set; } = default!;
    public SelectList ShootingTypes { get; set; } = default!;

    public class InputModel
    {
        [Required]
        public int FirearmId { get; set; }

        [Required]
        public int AmmoId { get; set; }

        [Required]
        public int ShootingTypeId { get; set; }

        [Required]
        [DataType(DataType.Date)]
        public DateTime ShootingDate { get; set; } = DateTime.Now;

        [Required]
        public int RoundsFired { get; set; }

        public bool Subtract { get; set; } = true;

        [MaxLength(255)]
        public string? Details { get; set; }
    }

    public void OnGet()
    {
        Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
        Ammunitions = new SelectList(_context.Ammunitions.Where(a => a.Status == "A"), "Id", "Manufacturer");
        ShootingTypes = new SelectList(_context.ShootingTypes.Where(s => s.Status == "A"), "Id", "Name");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
            Ammunitions = new SelectList(_context.Ammunitions.Where(a => a.Status == "A"), "Id", "Manufacturer");
            ShootingTypes = new SelectList(_context.ShootingTypes.Where(s => s.Status == "A"), "Id", "Name");
            return Page();
        }

        var ammo = await _context.Ammunitions.FindAsync(Input.AmmoId);
        if (ammo == null) return NotFound();

        var activity = new ShootingActivity
        {
            FirearmId = Input.FirearmId,
            AmmoId = Input.AmmoId,
            CaliberId = ammo.CaliberId,
            ShootingTypeId = Input.ShootingTypeId,
            ShootingDate = Input.ShootingDate,
            RoundsFired = Input.RoundsFired,
            Subtract = Input.Subtract,
            Details = Input.Details,
            Status = "A",
            STimestamp = DateTime.Now
        };

        _context.ShootingActivities.Add(activity);
        await _context.SaveChangesAsync();

        return RedirectToPage("/FirearmDetails", new { id = Input.FirearmId });
    }
}
